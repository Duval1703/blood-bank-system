<?php

namespace App\Livewire\BloodBank;

use App\Models\BloodUnit;
use App\Models\Donor;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class InventoryManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $bloodTypeFilter = '';
    public $statusFilter = '';
    public $dateFilter = '';
    
    public $showAddModal = false;
    public $showEditModal = false;
    public $showViewModal = false;
    
    public $selectedBloodUnit = null;
    public $editingBloodUnit = null;
    
    // Form fields
    public $unit_number;
    public $blood_type;
    public $collection_date;
    public $expiry_date;
    public $volume = 450;
    public $donor_id;
    public $donor_id_code;
    public $donation_establishment_id; // Establishment where blood is being donated
    public $notes;
    public $screening_results = [];
    public $selectedDonor = null; // To store donor info when ID code is entered
    public $donorNotFound = false; // Flag to show donor not found message

    public static function generateUnitNumber(): string
    {
        $year = date('Y');
        $prefix = 'BU' . $year;
        
        // Get the highest unit number for this year and current establishment
        $lastUnit = BloodUnit::where('unit_number', 'like', $prefix . '%')
            ->where('establishment_id', Auth::user()->establishment_id)
            ->orderBy('unit_number', 'desc')
            ->first();
        
        if ($lastUnit) {
            // Extract the numeric part and increment
            $lastNumber = intval(str_replace($prefix, '', $lastUnit->unit_number));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }

    // Removed global $rules to prevent automatic validation on field updates
    // Validation is now done explicitly in addBloodUnit() method

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        // Single blood bank - no establishment filtering needed
    }

    public function render()
    {
        $query = BloodUnit::with('donor')
            ->where('establishment_id', Auth::user()->establishment_id);

        // Apply filters
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('unit_number', 'like', '%' . $this->search . '%')
                  ->orWhereHas('donor', function ($subQuery) {
                      $subQuery->where('first_name', 'like', '%' . $this->search . '%')
                               ->orWhere('last_name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->bloodTypeFilter) {
            $query->where('blood_type', $this->bloodTypeFilter);
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->dateFilter) {
            $query->whereDate('created_at', $this->dateFilter);
        }

        $bloodUnits = $query->orderBy('created_at', 'desc')->paginate(15);

        // Allow donors from any establishment for donation
        $donors = Donor::where('is_eligible', true)
                      ->orderBy('last_name')
                      ->get();

        // Get all establishments for donation selection
        $establishments = \App\Models\Establishment::orderBy('name')->get();

        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $statuses = ['Available', 'Reserved', 'Near Expiry', 'Expired', 'Used', 'Discarded'];

        return view('livewire.blood-bank.inventory-management', compact(
            'bloodUnits',
            'donors',
            'establishments',
            'bloodTypes',
            'statuses'
        ))->layout('layouts.blood-bank');
    }

    public function openAddModal()
    {
        $this->reset(['blood_type', 'collection_date', 'expiry_date', 'volume', 'donor_id', 'donor_id_code', 'donation_establishment_id', 'notes', 'screening_results', 'selectedDonor', 'donorNotFound']);
        $this->unit_number = self::generateUnitNumber();
        $this->donation_establishment_id = Auth::user()->establishment_id; // Default to current establishment
        $this->showAddModal = true;
    }

    public function openEditModal(BloodUnit $bloodUnit)
    {
        $this->editingBloodUnit = $bloodUnit;
        $this->unit_number = $bloodUnit->unit_number;
        $this->blood_type = $bloodUnit->blood_type;
        $this->collection_date = $bloodUnit->collection_date->format('Y-m-d');
        $this->expiry_date = $bloodUnit->expiry_date->format('Y-m-d');
        $this->volume = $bloodUnit->volume;
        $this->donor_id = $bloodUnit->donor_id;
        $this->notes = $bloodUnit->notes;
        $this->screening_results = $bloodUnit->screening_results ?? [];
        $this->showEditModal = true;
    }

    public function openViewModal(BloodUnit $bloodUnit)
    {
        $this->selectedBloodUnit = $bloodUnit->load(['donor', 'distribution']);
        $this->showViewModal = true;
    }

    public function closeModal()
    {
        $this->showAddModal = false;
        $this->showEditModal = false;
        $this->showViewModal = false;
        $this->reset(['unit_number', 'blood_type', 'collection_date', 'expiry_date', 'volume', 'donor_id', 'donor_id_code', 'notes', 'screening_results', 'selectedDonor', 'donorNotFound']);
    }

    public function addBloodUnit()
    {
        try {
            // Validate donor is selected
            if (!$this->donor_id) {
                session()->flash('error', 'Please enter a valid donor ID and search for the donor.');
                return;
            }

            // Validate without unit_number since it's auto-generated
            $this->validate([
                'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
                'collection_date' => 'required|date|before_or_equal:today',
                'expiry_date' => 'required|date|after:collection_date',
                'volume' => 'required|integer|min:200|max:600',
                'notes' => 'nullable|string',
                'donor_id' => 'required|exists:donors,id',
                'donation_establishment_id' => 'required|exists:establishments,id',
            ]);

            $donor = Donor::findOrFail($this->donor_id);

            BloodUnit::create([
                'unit_number' => $this->unit_number, // Use auto-generated number
                'blood_type' => $this->blood_type,
                'collection_date' => $this->collection_date,
                'expiry_date' => $this->expiry_date,
                'volume' => $this->volume,
                'donor_id' => $this->donor_id,
                'establishment_id' => $this->donation_establishment_id, // Use selected donation establishment
                'status' => 'Available',
                'notes' => $this->notes,
                'screening_results' => $this->screening_results ?: [
                    'HIV' => 'Negative',
                    'Hepatitis B' => 'Negative',
                    'Hepatitis C' => 'Negative',
                    'Syphilis' => 'Negative',
                ],
            ]);

            $this->closeModal();
            $this->dispatch('refreshComponent');
            session()->flash('message', 'Blood unit added successfully.');
        } catch (\Exception $e) {
            \Log::error('Error adding blood unit: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'donor_id' => $this->donor_id,
                'establishment_id' => $this->donation_establishment_id,
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'Error adding blood unit: ' . $e->getMessage());
        }
    }

    public function updateBloodUnit()
    {
        $this->validate([
            'unit_number' => 'required|string|unique:blood_units,unit_number,' . $this->editingBloodUnit->id,
            'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'collection_date' => 'required|date|before_or_equal:today',
            'expiry_date' => 'required|date|after:collection_date',
            'volume' => 'required|integer|min:200|max:600',
            'donor_id' => 'required|exists:donors,id',
            'notes' => 'nullable|string',
        ]);

        $this->editingBloodUnit->update([
            'unit_number' => $this->unit_number,
            'blood_type' => $this->blood_type,
            'collection_date' => $this->collection_date,
            'expiry_date' => $this->expiry_date,
            'volume' => $this->volume,
            'donor_id' => $this->donor_id,
            'notes' => $this->notes,
            'screening_results' => $this->screening_results,
        ]);

        $this->closeModal();
        $this->dispatch('refreshComponent');
        session()->flash('message', 'Blood unit updated successfully.');
    }

    public function deleteBloodUnit(BloodUnit $bloodUnit)
    {
        if ($bloodUnit->distribution) {
            session()->flash('error', 'Cannot delete blood unit that is already distributed.');
            return;
        }

        $bloodUnit->delete();
        session()->flash('message', 'Blood unit deleted successfully.');
    }

    public function markAsExpired(BloodUnit $bloodUnit)
    {
        $bloodUnit->update(['status' => 'Expired']);
        session()->flash('message', 'Blood unit marked as expired.');
    }

    public function markAsDiscarded(BloodUnit $bloodUnit)
    {
        $bloodUnit->update(['status' => 'Discarded']);
        session()->flash('message', 'Blood unit marked as discarded.');
    }

    public function bulkMarkAsExpired()
    {
        $user = Auth::user();
        $establishmentIds = $user->getAccessibleEstablishmentsQuery()->pluck('id');

        BloodUnit::whereIn('establishment_id', $establishmentIds)
            ->where('expiry_date', '<', now())
            ->where('status', '!=', 'Expired')
            ->update(['status' => 'Expired']);

        session()->flash('message', 'Expired units have been marked.');
    }

    public function lookupDonorByCode()
    {
        // Reset previous states
        $this->selectedDonor = null;
        $this->donorNotFound = false;
        $this->donor_id = null;

        if (empty($this->donor_id_code)) {
            return;
        }

        // Search for donor by ID code
        $donor = Donor::where('donor_id_code', $this->donor_id_code)->first();
        
        if ($donor) {
            $this->selectedDonor = $donor;
            $this->donor_id = $donor->id;
            $this->blood_type = $donor->blood_type; // Auto-fill blood type
            $this->donorNotFound = false;
        } else {
            $this->donorNotFound = true;
            $this->selectedDonor = null;
            $this->donor_id = null;
        }
    }

    // Removed auto-search to prevent server errors
    // Users must click the "Search" button to lookup donor

    public function getStatusColor(string $status): string
    {
        return match($status) {
            'Available' => 'green',
            'Reserved' => 'blue',
            'Near Expiry' => 'yellow',
            'Expired' => 'red',
            'Used' => 'gray',
            'Discarded' => 'red',
            default => 'gray',
        };
    }

    public function updatedCollectionDate()
    {
        try {
            if ($this->collection_date) {
                // Automatically set expiry date to 42 days after collection
                $this->expiry_date = date('Y-m-d', strtotime($this->collection_date . ' +42 days'));
            }
        } catch (\Exception $e) {
            \Log::error('Error updating collection date: ' . $e->getMessage());
            // Silently fail - user can manually set expiry date
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'bloodTypeFilter', 'statusFilter', 'establishmentFilter', 'dateFilter']);
        
        $user = Auth::user();
        if ($user->isBloodBankManager()) {
            $this->establishmentFilter = $user->establishment_id;
        }
    }
}
