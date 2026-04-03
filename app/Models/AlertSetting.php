<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlertSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'low_stock_threshold',
        'expiry_alert_days',
        'critical_alerts_enabled',
    ];

    protected $casts = [
        'critical_alerts_enabled' => 'boolean',
    ];
}
