<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\BloodUnit;
use App\Models\Establishment;

class InventoryManagement extends Component
{
    public $showAddForm = false;
    public $unit_number;
    public $blood_type;
    public $volume = 450;
    public $collection_date;
    public $expiry_date;
    public $establishment_id;
    public $notes;

    protected $rules = [
        'unit_number' => 'required|string|max:255',
        'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        'volume' => 'required|integer|min:200|max:600',
        'collection_date' => 'required|date|before_or_equal:today',
        'expiry_date' => 'required|date|after:collection_date',
        'establishment_id' => 'required|exists:establishments,id',
        'notes' => 'nullable|string|max:1000',
    ];

    public function toggleAddForm()
    {
        $this->showAddForm = !$this->showAddForm;
        $this->resetForm();
    }

    public function addBloodUnit()
    {
        $this->validate();

        BloodUnit::create([
            'unit_number' => $this->unit_number,
            'blood_type' => $this->blood_type,
            'status' => 'Available',
            'volume' => $this->volume,
            'collection_date' => $this->collection_date,
            'expiry_date' => $this->expiry_date,
            'notes' => $this->notes,
            'establishment_id' => $this->establishment_id,
            'screening_results' => null,
        ]);

        session()->flash('message', 'Blood unit added successfully!');
        $this->toggleAddForm();
    }

    public function resetForm()
    {
        $this->reset(['unit_number', 'blood_type', 'volume', 'collection_date', 'expiry_date', 'establishment_id', 'notes']);
        $this->collection_date = now()->format('Y-m-d');
        $this->expiry_date = now()->addDays(42)->format('Y-m-d');
    }

    public function render()
    {
        $inventory = BloodUnit::with('establishment')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('blood_type')
            ->map(function ($group) {
                return [
                    'blood_type' => $group->first()->blood_type,
                    'total_units' => $group->count(),
                    'available_units' => $group->where('status', 'available')->count(),
                    'expiring_soon' => $group->where('expiry_date', '<=', now()->addDays(7))->count(),
                ];
            });

        $establishments = Establishment::where('is_active', true)->get();

        return view('livewire.admin.inventory-management', [
            'inventory' => $inventory,
            'establishments' => $establishments
        ]);
    }
}
