<?php

namespace App\Livewire\Admin;

use App\Models\Establishment;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class EstablishmentManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $showAddModal = false;
    public $showEditModal = false;
    public $selectedEstablishment = null;

    // Form fields
    public $name;
    public $code;
    public $type = 'Blood Bank';
    public $address;
    public $city;
    public $state;
    public $zip_code;
    public $phone;
    public $email;
    public $contact_person;
    public $is_active = true;

    // Manager account fields
    public $manager_name;
    public $manager_email;
    public $manager_password;

    protected $rules = [
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:50|unique:establishments,code',
        'type' => 'required|in:Blood Bank,Hospital,Clinic',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:100',
        'zip_code' => 'required|string|max:20',
        'phone' => 'required|string|max:20',
        'email' => 'nullable|email|max:255',
        'contact_person' => 'nullable|string|max:255',
        'is_active' => 'boolean',
        'manager_name' => 'required|string|max:255',
        'manager_email' => 'required|email|unique:users,email',
        'manager_password' => 'required|string|min:8',
    ];

    public function render()
    {
        $establishments = Establishment::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('code', 'like', '%' . $this->search . '%')
                    ->orWhere('city', 'like', '%' . $this->search . '%');
            })
            ->withCount(['users', 'donors', 'bloodUnits'])
            ->paginate(10);

        return view('livewire.admin.establishment-management', compact('establishments'))
            ->layout('layouts.admin');
    }

    public function openAddModal()
    {
        $this->resetForm();
        $this->showAddModal = true;
    }

    public function closeModal()
    {
        $this->showAddModal = false;
        $this->showEditModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['name', 'code', 'type', 'address', 'city', 'state', 'zip_code', 'phone', 'email', 'contact_person', 'is_active', 'manager_name', 'manager_email', 'manager_password']);
        $this->type = 'Blood Bank';
        $this->is_active = true;
    }

    public function addEstablishment()
    {
        $this->validate();

        $establishment = Establishment::create([
            'name' => $this->name,
            'code' => $this->code,
            'type' => $this->type,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'phone' => $this->phone,
            'email' => $this->email,
            'contact_person' => $this->contact_person,
            'is_active' => $this->is_active,
        ]);

        // Create manager account
        User::create([
            'name' => $this->manager_name,
            'email' => $this->manager_email,
            'password' => Hash::make($this->manager_password),
            'role' => 'Blood Bank Manager',
            'establishment_id' => $establishment->id,
        ]);

        $this->closeModal();
        session()->flash('message', 'Establishment and manager account created successfully.');
    }

    public function toggleStatus($id)
    {
        $establishment = Establishment::findOrFail($id);
        $establishment->update(['is_active' => !$establishment->is_active]);
        
        session()->flash('message', 'Establishment status updated.');
    }

    public function deleteEstablishment($id)
    {
        Establishment::findOrFail($id)->delete();
        session()->flash('message', 'Establishment deleted successfully.');
    }
}
