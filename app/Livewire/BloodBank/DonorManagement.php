<?php

namespace App\Livewire\BloodBank;

use App\Models\Donor;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DonorManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $bloodTypeFilter = '';
    public $eligibilityFilter = '';
    
    public $showAddModal = false;
    public $showEditModal = false;
    public $showViewModal = false;
    public $showHistoryModal = false;
    public $showScreeningModal = false;
    
    public $selectedDonor = null;
    public $editingDonor = null;
    
    // Form fields
    public $donor_id_code;
    public $first_name;
    public $last_name;
    public $date_of_birth;
    public $gender;
    public $phone;
    public $email;
    public $address;
    public $occupation;
    public $blood_type;
    public $medical_conditions;
    public $current_medications;
    public $allergies;
    public $is_eligible = false;
    public $weight;
    public $notes;
    
    // Screening form fields
    public $screening_eligibility;
    public $screening_blood_type;
    public $screening_notes;

    protected $rules = [
        'donor_id_code' => 'nullable|unique:donors,donor_id_code',
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'date_of_birth' => 'required|date|before:today',
        'gender' => 'required|in:Male,Female,Other',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|unique:donors,email',
        'address' => 'required|string|max:255',
        'occupation' => 'nullable|string|max:255',
        'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        'medical_conditions' => 'nullable|string',
        'current_medications' => 'nullable|string',
        'allergies' => 'nullable|string',
        'is_eligible' => 'boolean',
        'weight' => 'nullable|numeric|min:40|max:200',
        'notes' => 'nullable|string',
    ];
    
    protected $screeningRules = [
        'screening_eligibility' => 'required|boolean',
        'screening_blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        'screening_notes' => 'nullable|string',
    ];

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        // Each establishment should have its own donors
    }

    public function render()
    {
        $query = Donor::where('establishment_id', Auth::user()->establishment_id);

        // Apply filters
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                  ->orWhere('last_name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->bloodTypeFilter) {
            $query->where('blood_type', $this->bloodTypeFilter);
        }

        if ($this->eligibilityFilter !== '') {
            $query->where('is_eligible', $this->eligibilityFilter);
        }


        $donors = $query->orderBy('last_name', 'asc')->paginate(15);

        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

        return view('livewire.blood-bank.donor-management', compact(
            'donors',
            'bloodTypes'
        ))->layout('layouts.blood-bank');
    }

    public function openAddModal()
    {
        $this->resetForm();
        $this->showAddModal = true;
    }

    public function openEditModal(Donor $donor)
    {
        $this->editingDonor = $donor;
        $this->first_name = $donor->first_name;
        $this->last_name = $donor->last_name;
        $this->date_of_birth = $donor->date_of_birth->format('Y-m-d');
        $this->gender = $donor->gender;
        $this->phone = $donor->phone;
        $this->email = $donor->email;
        $this->address = $donor->address;
        $this->occupation = $donor->occupation;
        $this->blood_type = $donor->blood_type;
        $this->medical_conditions = $donor->medical_conditions;
        $this->current_medications = $donor->current_medications;
        $this->allergies = $donor->allergies;
        $this->is_eligible = $donor->is_eligible;
        $this->weight = $donor->weight;
        $this->notes = $donor->notes;
        $this->showEditModal = true;
    }

    public function openViewModal(Donor $donor)
    {
        $this->selectedDonor = $donor;
        $this->showViewModal = true;
    }

    public function openScreeningModal(Donor $donor)
    {
        $this->selectedDonor = $donor;
        $this->screening_eligibility = $donor->is_eligible;
        $this->screening_blood_type = $donor->blood_type;
        $this->screening_notes = '';
        $this->showScreeningModal = true;
    }

    public function openHistoryModal(Donor $donor)
    {
        $this->selectedDonor = $donor->load(['bloodUnits' => function ($query) {
            $query->with('distribution')->orderBy('created_at', 'desc');
        }]);
        $this->showHistoryModal = true;
    }

    public function closeModal()
    {
        $this->showAddModal = false;
        $this->showEditModal = false;
        $this->showViewModal = false;
        $this->showHistoryModal = false;
        $this->showScreeningModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'donor_id_code', 'first_name', 'last_name', 'date_of_birth', 'gender', 'phone', 'email',
            'address', 'occupation', 'blood_type',
            'medical_conditions', 'current_medications', 'allergies', 'is_eligible',
            'weight', 'notes', 'screening_eligibility', 'screening_blood_type', 'screening_notes'
        ]);
        $this->is_eligible = false;
    }

    public function addDonor()
    {
        $this->validate();

        Donor::create([
            'donor_id_code' => Donor::generateDonorIdCodeForEstablishment(auth()->user()->establishment_id),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'occupation' => $this->occupation,
            'blood_type' => $this->blood_type,
            'medical_conditions' => $this->medical_conditions,
            'current_medications' => $this->current_medications,
            'allergies' => $this->allergies,
            'is_eligible' => $this->is_eligible,
            'weight' => $this->weight,
            'notes' => $this->notes,
            'establishment_id' => auth()->user()->establishment_id,
            'total_donations' => 0,
        ]);

        $this->closeModal();
        $this->dispatch('refreshComponent');
        session()->flash('message', 'Donor registered successfully.');
    }

    public function updateDonor()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female,Other',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:donors,email,' . $this->editingDonor->id,
            'address' => 'required|string|max:255',
            'occupation' => 'nullable|string|max:255',
            'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'medical_conditions' => 'nullable|string',
            'current_medications' => 'nullable|string',
            'allergies' => 'nullable|string',
            'is_eligible' => 'boolean',
            'weight' => 'nullable|numeric|min:40|max:200',
            'notes' => 'nullable|string',
        ]);

        $this->editingDonor->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'occupation' => $this->occupation,
            'blood_type' => $this->blood_type,
            'medical_conditions' => $this->medical_conditions,
            'current_medications' => $this->current_medications,
            'allergies' => $this->allergies,
            'is_eligible' => $this->is_eligible,
            'weight' => $this->weight,
            'notes' => $this->notes,
        ]);

        $this->closeModal();
        $this->dispatch('refreshComponent');
        session()->flash('message', 'Donor updated successfully.');
    }

    public function deleteDonor(Donor $donor)
    {
        if ($donor->bloodUnits()->count() > 0) {
            session()->flash('error', 'Cannot delete donor with existing blood donations.');
            return;
        }

        $donor->delete();
        session()->flash('message', 'Donor deleted successfully.');
    }

    public function toggleEligibility(Donor $donor)
    {
        $donor->update(['is_eligible' => !$donor->is_eligible]);
        session()->flash('message', 'Donor eligibility updated.');
    }

    public function updateScreening()
    {
        $this->validate($this->screeningRules);

        $this->selectedDonor->update([
            'is_eligible' => $this->screening_eligibility,
            'blood_type' => $this->screening_blood_type,
            'notes' => $this->screening_notes ? ($this->selectedDonor->notes ? $this->selectedDonor->notes . "\n\n" . $this->screening_notes : $this->screening_notes) : $this->selectedDonor->notes,
        ]);

        $this->closeModal();
        $this->dispatch('refreshComponent');
        session()->flash('message', 'Donor screening information updated successfully.');
    }

    public function getEligibilityColor(bool $isEligible): string
    {
        return $isEligible ? 'green' : 'red';
    }

    public function resetFilters()
    {
        $this->reset(['search', 'bloodTypeFilter', 'eligibilityFilter']);
    }
}
