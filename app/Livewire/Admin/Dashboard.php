<?php

namespace App\Livewire\Admin;

use App\Models\Establishment;
use App\Models\User;
use App\Models\Donor;
use App\Models\BloodUnit;
use App\Models\Distribution;
use App\Models\Alert;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_establishments' => Establishment::count(),
            'total_users' => User::count(),
            'total_users_all_establishments' => User::count(), // Total users across all establishments
            'total_donors' => Donor::count(),
            'total_blood_units' => BloodUnit::count(),
            'total_distributions' => Distribution::count(),
            'active_alerts' => Alert::where('is_active', true)->count(),
        ];

        $establishments = Establishment::withCount(['donors', 'bloodUnits', 'distributions', 'alerts'])
            ->get();

        $recentEstablishments = Establishment::latest()->take(5)->get();
        $criticalAlerts = Alert::where('is_active', true)
            ->where('severity', 'Critical')
            ->with('establishment')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', compact('stats', 'establishments', 'recentEstablishments', 'criticalAlerts'))
            ->layout('layouts.admin');
    }
}
