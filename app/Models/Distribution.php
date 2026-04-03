<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Distribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'distribution_id',
        'blood_unit_id',
        'department',
        'status',
        'purpose',
        'patient_name',
        'patient_id',
        'reserved_until',
        'created_by',
        'issued_date',
        'cancelled_date',
        'cancellation_reason',
        'establishment_id',
    ];

    protected $casts = [
        'reserved_until' => 'datetime',
        'issued_date' => 'datetime',
        'cancelled_date' => 'datetime',
    ];

    public function bloodUnit(): BelongsTo
    {
        return $this->belongsTo(BloodUnit::class);
    }


    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    public function getIsExpiredReservationAttribute(): bool
    {
        return $this->status === 'Reserved' && 
               $this->reserved_until && 
               $this->reserved_until->isPast();
    }

    public function issue(): void
    {
        $this->update([
            'status' => 'Issued',
            'issued_date' => now(),
        ]);

        $this->bloodUnit->update(['status' => 'Used']);
    }

    public function cancel(string $reason = null): void
    {
        $this->update([
            'status' => 'Cancelled',
            'cancelled_date' => now(),
            'cancellation_reason' => $reason,
        ]);

        $this->bloodUnit->update(['status' => 'Available']);
    }

    protected static function booted()
    {
        static::created(function ($distribution) {
            if ($distribution->status === 'Reserved') {
                $distribution->bloodUnit->update(['status' => 'Reserved']);
            }
        });

        static::updated(function ($distribution) {
            if ($distribution->wasChanged('status')) {
                if ($distribution->status === 'Reserved') {
                    $distribution->bloodUnit->update(['status' => 'Reserved']);
                } elseif ($distribution->status === 'Issued') {
                    $distribution->bloodUnit->update(['status' => 'Used']);
                } elseif ($distribution->status === 'Cancelled') {
                    $distribution->bloodUnit->update(['status' => 'Available']);
                }
            }
        });
    }
}
