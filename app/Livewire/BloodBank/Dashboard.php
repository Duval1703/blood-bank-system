<?php

namespace App\Livewire\BloodBank;

use App\Models\BloodUnit;
use App\Models\Donor;
use App\Models\Alert;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $totalBloodUnits;
    public $totalDonors;
    public $criticalAlertsCount;
    public $bloodTypeStock = [];
    public $recentAlerts = [];
    public $upcomingExpirations = [];
    public $usageTrends = [];

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        // Single blood bank - no establishment filtering needed

        // Summary Statistics
        $this->totalBloodUnits = BloodUnit::where('status', 'Available')->count();
        $this->totalDonors = Donor::count();
        $this->criticalAlertsCount = Alert::where('is_active', true)
            ->where('severity', 'Critical')
            ->count();

        // Blood Type Inventory Grid
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        foreach ($bloodTypes as $type) {
            $available = BloodUnit::where('blood_type', $type)
                ->where('status', 'Available')
                ->count();

            $reserved = BloodUnit::where('blood_type', $type)
                ->where('status', 'Reserved')
                ->count();

            $nearExpiry = BloodUnit::where('blood_type', $type)
                ->where('status', 'Near Expiry')
                ->count();

            $this->bloodTypeStock[$type] = [
                'available' => $available,
                'reserved' => $reserved,
                'near_expiry' => $nearExpiry,
                'total' => $available + $reserved + $nearExpiry,
                'status' => $this->getStockStatus($available),
            ];
        }

        // Recent Alerts
        $this->recentAlerts = Alert::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Upcoming Expirations (next 7 days)
        $sevenDaysFromNow = now()->addDays(7);
        $this->upcomingExpirations = BloodUnit::whereBetween('expiry_date', [now(), $sevenDaysFromNow])
            ->where('status', '!=', 'Expired')
            ->with('donor')
            ->orderBy('expiry_date', 'asc')
            ->limit(10)
            ->get();

        // Usage Trends (last 30 days)
        $this->loadUsageTrends();
    }

    private function getStockStatus(int $available): string
    {
        if ($available <= 5) {
            return 'critical';
        } elseif ($available <= 10) {
            return 'low';
        } else {
            return 'good';
        }
    }

    private function loadUsageTrends(): void
    {
        $thirtyDaysAgo = now()->subDays(30);
        
        try {
            // Try to get usage data from distributions
            $usageData = \App\Models\Distribution::where('created_at', '>=', $thirtyDaysAgo)
                ->selectRaw('DATE(created_at) as date, COUNT(*) as units_used')
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();

            // Fill in missing dates with zero usage
            $trends = [];
            for ($i = 29; $i >= 0; $i--) {
                $date = now()->subDays($i)->format('Y-m-d');
                $usage = $usageData->firstWhere('date', $date);
                $trends[] = [
                    'date' => now()->subDays($i)->format('M d'),
                    'units_used' => $usage ? $usage->units_used : 0,
                ];
            }

            $this->usageTrends = $trends;
        } catch (\Exception $e) {
            // If there's an error, create empty trends
            $trends = [];
            for ($i = 29; $i >= 0; $i--) {
                $trends[] = [
                    'date' => now()->subDays($i)->format('M d'),
                    'units_used' => 0,
                ];
            }
            $this->usageTrends = $trends;
        }
    }

    public function getStockColor(string $status): string
    {
        return match($status) {
            'critical' => 'red',
            'low' => 'yellow',
            'good' => 'green',
            default => 'gray',
        };
    }

    public function getAlertColor(string $severity): string
    {
        return match($severity) {
            'Critical' => 'red',
            'Warning' => 'yellow',
            'Info' => 'blue',
            default => 'gray',
        };
    }

    public function render()
    {
        return view('livewire.blood-bank.dashboard')
            ->layout('layouts.blood-bank');
    }
}
