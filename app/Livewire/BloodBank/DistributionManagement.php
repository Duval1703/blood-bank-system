<?php

namespace App\Livewire\BloodBank;

use App\Models\Distribution;
use App\Models\BloodUnit;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DistributionManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $departmentFilter = '';
    public $dateFilter = '';
    
    public $showAddModal = false;
    public $showEditModal = false;
    public $showViewModal = false;
    
    public $selectedDistribution = null;
    public $editingDistribution = null;
    
    // Form fields
    public $blood_unit_id;
    public $department;
    public $purpose;
    public $patient_name;
    public $patient_id;
    public $reserved_until;

    protected $rules = [
        'blood_unit_id' => 'required|exists:blood_units,id',
        'department' => 'required|in:Emergency,Surgery,Maternity,ICU,Pediatrics,General Ward,Other',
        'purpose' => 'required|string|max:255',
        'patient_name' => 'nullable|string|max:255',
        'patient_id' => 'nullable|string|max:255',
        'reserved_until' => 'nullable|date|after:now',
    ];

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        // Single blood bank - no establishment filtering needed
    }

    public function render()
    {
        $query = Distribution::with(['bloodUnit.donor', 'createdBy']);

        // Apply filters
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('patient_name', 'like', '%' . $this->search . '%')
                  ->orWhere('purpose', 'like', '%' . $this->search . '%')
                  ->orWhere('distribution_id', 'like', '%' . $this->search . '%')
                  ->orWhereHas('bloodUnit', function ($subQuery) {
                      $subQuery->where('unit_number', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->departmentFilter) {
            $query->where('department', $this->departmentFilter);
        }


        if ($this->dateFilter) {
            $query->whereDate('created_at', $this->dateFilter);
        }

        $distributions = $query->orderBy('created_at', 'desc')->paginate(15);

        $statuses = ['Reserved', 'Issued', 'Cancelled'];
        $departments = ['Emergency', 'Surgery', 'Maternity', 'ICU', 'Pediatrics', 'General Ward', 'Other'];

        // Get available blood units for dropdown
        $availableBloodUnits = BloodUnit::where('status', 'Available')
            ->with('donor')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.blood-bank.distribution-management', compact(
            'distributions',
            'availableBloodUnits',
            'statuses',
            'departments'
        ))->layout('layouts.blood-bank');
    }

    public function openAddModal()
    {
        $this->resetForm();
        $this->showAddModal = true;
    }

    public function openEditModal(Distribution $distribution)
    {
        $this->editingDistribution = $distribution;
        $this->blood_unit_id = $distribution->blood_unit_id;
        $this->department = $distribution->department;
        $this->purpose = $distribution->purpose;
        $this->patient_name = $distribution->patient_name;
        $this->patient_id = $distribution->patient_id;
        $this->reserved_until = $distribution->reserved_until?->format('Y-m-d H:i');
        $this->showEditModal = true;
    }

    public function openViewModal(Distribution $distribution)
    {
        $this->selectedDistribution = $distribution->load(['bloodUnit.donor', 'establishment', 'createdBy']);
        $this->showViewModal = true;
    }

    public function closeModal()
    {
        $this->showAddModal = false;
        $this->showEditModal = false;
        $this->showViewModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'blood_unit_id', 'department', 'purpose', 'patient_name', 
            'patient_id', 'reserved_until'
        ]);
    }

    public function addDistribution()
    {
        $this->validate();

        // Check if blood unit is still available
        $bloodUnit = BloodUnit::find($this->blood_unit_id);
        if ($bloodUnit->status !== 'Available') {
            session()->flash('error', 'This blood unit is no longer available.');
            return;
        }

        $distribution = Distribution::create([
            'distribution_id' => 'DIST-' . str_pad(Distribution::count() + 1, 4, '0', STR_PAD_LEFT),
            'blood_unit_id' => $this->blood_unit_id,
            'department' => $this->department,
            'purpose' => $this->purpose,
            'patient_name' => $this->patient_name,
            'patient_id' => $this->patient_id,
            'reserved_until' => $this->reserved_until,
            'created_by' => Auth::id() ?? 1,
            'establishment_id' => $bloodUnit->establishment_id,
        ]);

        // Update blood unit status
        $bloodUnit->update(['status' => 'Reserved']);

        $this->closeModal();
        $this->dispatch('refreshComponent');
        session()->flash('message', 'Distribution created successfully.');
    }

    public function updateDistribution()
    {
        $this->validate();

        $this->editingDistribution->update([
            'department' => $this->department,
            'purpose' => $this->purpose,
            'patient_name' => $this->patient_name,
            'patient_id' => $this->patient_id,
            'reserved_until' => $this->reserved_until,
        ]);

        $this->closeModal();
        $this->dispatch('refreshComponent');
        session()->flash('message', 'Distribution updated successfully.');
    }

    public function issueDistribution(Distribution $distribution)
    {
        $distribution->update([
            'status' => 'Issued',
            'issued_date' => now(),
        ]);
        
        $distribution->bloodUnit->update(['status' => 'Issued']);
        
        session()->flash('message', 'Blood unit issued successfully.');
    }

    public function cancelDistribution(Distribution $distribution)
    {
        $distribution->update([
            'status' => 'Cancelled',
            'cancelled_date' => now(),
        ]);
        
        $distribution->bloodUnit->update(['status' => 'Available']);
        
        session()->flash('message', 'Distribution cancelled successfully.');
    }

    public function deleteDistribution(Distribution $distribution)
    {
        if ($distribution->status === 'Issued') {
            session()->flash('error', 'Cannot delete issued distribution.');
            return;
        }

        // Return blood unit to available status
        $distribution->bloodUnit->update(['status' => 'Available']);
        
        $distribution->delete();
        session()->flash('message', 'Distribution deleted successfully.');
    }

    public function getStatusColor(string $status): string
    {
        return match($status) {
            'Reserved' => 'blue',
            'Issued' => 'green',
            'Cancelled' => 'gray',
            default => 'gray',
        };
    }

    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'departmentFilter', 'establishmentFilter', 'dateFilter']);
        
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isBloodBankManager()) {
                $this->establishmentFilter = $user->establishment_id;
            }
        }
    }
}
