<?php

namespace App\Livewire\BloodBank;

use App\Models\Alert;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AlertManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $severityFilter = '';
    public $statusFilter = '';
    public $dateFilter = '';
    public $bloodTypeFilter = '';
    
    public $showAddModal = false;
    public $showViewModal = false;
    
    public $selectedAlert = null;
    
    // Form fields
    public $alert_type;
    public $blood_type;
    public $message;
    public $severity;
    public $current_level;
    public $threshold_level;

    protected $rules = [
        'alert_type' => 'required|in:Critical Stock,Low Stock,Expiring Soon,Surplus,Other',
        'blood_type' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        'message' => 'required|string|max:1000',
        'severity' => 'required|in:Critical,Warning,Info',
        'current_level' => 'nullable|integer|min:0',
        'threshold_level' => 'nullable|integer|min:0',
    ];

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        // Single blood bank - no establishment filtering needed
    }

    public function render()
    {
        $query = Alert::with('resolvedBy');

        // Apply filters
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('message', 'like', '%' . $this->search . '%')
                  ->orWhere('notes', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->severityFilter) {
            $query->where('severity', $this->severityFilter);
        }

        if ($this->bloodTypeFilter) {
            $query->where('blood_type', $this->bloodTypeFilter);
        }

        if ($this->statusFilter !== '') {
            if ($this->statusFilter === 'active') {
                $query->where('is_active', true);
            } elseif ($this->statusFilter === 'resolved') {
                $query->where('is_active', false);
            }
        }

        if ($this->dateFilter) {
            $query->whereDate('created_at', $this->dateFilter);
        }

        $alerts = $query->orderBy('created_at', 'desc')->paginate(15);

        $severities = ['Critical', 'Warning', 'Info'];
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $alertTypes = ['Critical Stock', 'Low Stock', 'Expiring Soon', 'Surplus', 'Other'];

        // Get blood unit statistics
        $bloodUnitStats = $this->getBloodUnitStatistics();

        return view('livewire.blood-bank.alert-management', compact(
            'alerts',
            'severities',
            'bloodTypes',
            'alertTypes',
            'bloodUnitStats'
        ))->layout('layouts.blood-bank');
    }

    public function openAddModal()
    {
        $this->resetForm();
        $this->showAddModal = true;
    }

    public function openViewModal(Alert $alert)
    {
        $this->selectedAlert = $alert->load('resolvedBy');
        $this->showViewModal = true;
    }

    public function closeModal()
    {
        $this->showAddModal = false;
        $this->showViewModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['alert_type', 'blood_type', 'message', 'severity', 'current_level', 'threshold_level']);
    }

    public function addAlert()
    {
        $this->validate();

        Alert::create([
            'alert_type' => $this->alert_type,
            'blood_type' => $this->blood_type,
            'message' => $this->message,
            'severity' => $this->severity,
            'current_level' => $this->current_level,
            'threshold_level' => $this->threshold_level,
            'is_active' => true,
        ]);

        $this->closeModal();
        $this->dispatch('refreshComponent');
        session()->flash('message', 'Alert created successfully.');
    }

    public function resolveAlert(Alert $alert)
    {
        $alert->resolve(Auth::id());
        session()->flash('message', 'Alert resolved successfully.');
    }

    public function deleteAlert(Alert $alert)
    {
        $alert->delete();
        session()->flash('message', 'Alert deleted successfully.');
    }

    public function getSeverityColor(string $severity): string
    {
        return match($severity) {
            'Critical' => 'red',
            'Warning' => 'yellow',
            'Info' => 'blue',
            default => 'gray',
        };
    }

    public function getSeverityIcon(string $severity): string
    {
        return match($severity) {
            'Critical' => 'exclamation-triangle',
            'Warning' => 'exclamation-circle',
            'Info' => 'information-circle',
            default => 'question-circle',
        };
    }

    public function getBloodUnitStatistics()
    {
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $stats = [];
        
        foreach ($bloodTypes as $bloodType) {
            $stats[$bloodType] = [
                'available' => \App\Models\BloodUnit::where('blood_type', $bloodType)
                    ->where('status', 'Available')
                    ->count(),
                'reserved' => \App\Models\BloodUnit::where('blood_type', $bloodType)
                    ->where('status', 'Reserved')
                    ->count(),
                'expired' => \App\Models\BloodUnit::where('blood_type', $bloodType)
                    ->where('status', 'Expired')
                    ->count(),
                'total' => \App\Models\BloodUnit::where('blood_type', $bloodType)->count(),
            ];
        }
        
        return $stats;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'severityFilter', 'bloodTypeFilter', 'statusFilter', 'dateFilter']);
    }

    public function bulkResolveCriticalAlerts()
    {
        Alert::where('severity', 'Critical')
            ->where('is_active', true)
            ->update([
                'is_active' => false,
                'resolved_at' => now(),
                'resolved_by' => Auth::id() ?? 1,
            ]);

        session()->flash('message', 'All critical alerts resolved.');
    }

    public function generateLowStockAlerts()
    {
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

        foreach ($bloodTypes as $bloodType) {
            $available = \App\Models\BloodUnit::where('blood_type', $bloodType)
                ->where('status', 'Available')
                ->count();

            if ($available <= 5) {
                Alert::createCriticalStockAlert($bloodType, $available, 5);
            } elseif ($available <= 10) {
                Alert::createLowStockAlert($bloodType, $available, 10);
            }
        }

        session()->flash('message', 'Low stock alerts generated successfully.');
    }
}
