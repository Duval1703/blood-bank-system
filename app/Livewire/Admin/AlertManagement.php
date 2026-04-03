<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Alert;
use App\Models\AlertSetting;

class AlertManagement extends Component
{
    public $low_stock_threshold = 10;
    public $expiry_alert_days = 7;
    public $critical_alerts_enabled = true;

    public function mount()
    {
        $settings = AlertSetting::first();
        if ($settings) {
            $this->low_stock_threshold = $settings->low_stock_threshold;
            $this->expiry_alert_days = $settings->expiry_alert_days;
            $this->critical_alerts_enabled = (bool) $settings->critical_alerts_enabled;
        }
    }

    public function saveSettings()
    {
        $this->validate([
            'low_stock_threshold' => 'required|integer|min:1|max:1000',
            'expiry_alert_days' => 'required|integer|min:1|max:365',
            'critical_alerts_enabled' => 'required|boolean',
        ]);

        AlertSetting::updateOrCreate(
            ['id' => 1],
            [
                'low_stock_threshold' => $this->low_stock_threshold,
                'expiry_alert_days' => $this->expiry_alert_days,
                'critical_alerts_enabled' => $this->critical_alerts_enabled,
            ]
        );

        session()->flash('message', 'Alert settings saved successfully!');
    }

    public function render()
    {
        $alerts = Alert::with('establishment')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.admin.alert-management', [
            'alerts' => $alerts
        ]);
    }
}
