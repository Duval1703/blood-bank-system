<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'alert_type',
        'blood_type',
        'severity',
        'message',
        'current_level',
        'threshold_level',
        'is_active',
        'resolved_at',
        'resolved_by',
        'resolution_notes',
        'establishment_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'resolved_at' => 'datetime',
        'current_level' => 'integer',
        'threshold_level' => 'integer',
    ];


    public function resolvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    public function resolve(int $userId, string $notes = null): void
    {
        $this->update([
            'is_active' => false,
            'resolved_at' => now(),
            'resolved_by' => $userId,
            'resolution_notes' => $notes,
        ]);
    }

    public function getSeverityColorAttribute(): string
    {
        return match($this->severity) {
            'Critical' => 'red',
            'Warning' => 'yellow',
            'Info' => 'blue',
            default => 'gray',
        };
    }

    public function getIconAttribute(): string
    {
        return match($this->alert_type) {
            'Critical Stock' => 'exclamation-triangle',
            'Low Stock' => 'exclamation-circle',
            'Expiring Soon' => 'clock',
            'Surplus' => 'chart-line',
            default => 'info-circle',
        };
    }

    public static function createCriticalStockAlert(string $bloodType, int $currentLevel, int $threshold): self
    {
        return self::create([
            'alert_type' => 'Critical Stock',
            'blood_type' => $bloodType,
            'severity' => 'Critical',
            'message' => "Critical stock level for blood type {$bloodType}: {$currentLevel} units remaining (threshold: {$threshold})",
            'current_level' => $currentLevel,
            'threshold_level' => $threshold,
        ]);
    }

    public static function createLowStockAlert(string $bloodType, int $currentLevel, int $threshold): self
    {
        return self::create([
            'alert_type' => 'Low Stock',
            'blood_type' => $bloodType,
            'severity' => 'Warning',
            'message' => "Low stock level for blood type {$bloodType}: {$currentLevel} units remaining (threshold: {$threshold})",
            'current_level' => $currentLevel,
            'threshold_level' => $threshold,
        ]);
    }

    public static function createExpiringSoonAlert(string $bloodType, int $count): self
    {
        return self::create([
            'alert_type' => 'Expiring Soon',
            'blood_type' => $bloodType,
            'severity' => 'Warning',
            'message' => "{$count} units of blood type {$bloodType} expiring within 7 days",
            'current_level' => $count,
            'threshold_level' => 1,
        ]);
    }
}
