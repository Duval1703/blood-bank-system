<?php

namespace App\Livewire\BloodBank;

use App\Models\Establishment;
use App\Models\BloodUnit;
use Livewire\Component;

class PartnerEstablishments extends Component
{
    public $search = '';
    public $showInventoryModal = false;
    public $selectedEstablishment = null;
    public $partnerInventory = [];
    public $inventoryVisible = true;

    public function mount()
    {
        // Get current establishment's visibility setting
        $currentEstablishment = auth()->user()->establishment;
        if ($currentEstablishment) {
            $this->inventoryVisible = $currentEstablishment->inventory_visible ?? true;
        }
    }

    public function render()
    {
        $currentEstablishmentId = auth()->user()->establishment_id;
        
        $partners = Establishment::where('id', '!=', $currentEstablishmentId)
            ->where('is_active', true)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%')
                      ->orWhere('city', 'like', '%' . $this->search . '%');
                });
            })
            ->withCount(['bloodUnits' => function ($query) {
                $query->where('status', 'Available');
            }])
            ->get();

        return view('livewire.blood-bank.partner-establishments', compact('partners'))
            ->layout('layouts.blood-bank');
    }

    public function toggleInventoryVisibility()
    {
        $establishment = auth()->user()->establishment;
        if ($establishment) {
            $newVisibility = !($establishment->inventory_visible ?? true);
            $establishment->update(['inventory_visible' => $newVisibility]);
            $this->inventoryVisible = $newVisibility;
            
            session()->flash('message', $newVisibility ? 
                'Your inventory is now visible to partner establishments.' : 
                'Your inventory is now hidden from partner establishments.');
        }
    }

    public function viewPartnerInventory($establishmentId)
    {
        $establishment = Establishment::findOrFail($establishmentId);
        
        // Check if establishment has made inventory visible
        if (!($establishment->inventory_visible ?? true)) {
            session()->flash('error', 'This establishment has made their inventory private.');
            return;
        }

        $this->selectedEstablishment = $establishment;
        
        // Get blood type inventory
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $this->partnerInventory = [];
        
        foreach ($bloodTypes as $type) {
            $available = BloodUnit::where('establishment_id', $establishmentId)
                ->where('blood_type', $type)
                ->where('status', 'Available')
                ->count();
                
            $nearExpiry = BloodUnit::where('establishment_id', $establishmentId)
                ->where('blood_type', $type)
                ->where('status', 'Near Expiry')
                ->count();
                
            $this->partnerInventory[$type] = [
                'available' => $available,
                'near_expiry' => $nearExpiry,
                'total' => $available + $nearExpiry,
            ];
        }
        
        $this->showInventoryModal = true;
    }

    public function closeModal()
    {
        $this->showInventoryModal = false;
        $this->selectedEstablishment = null;
        $this->partnerInventory = [];
    }
}
