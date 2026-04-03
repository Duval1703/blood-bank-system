<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BloodUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_number',
        'blood_type',
        'status',
        'collection_date',
        'expiry_date',
        'volume',
        'screening_results',
        'notes',
        'donor_id',
        'establishment_id',
    ];

    protected $casts = [
        'collection_date' => 'date',
        'expiry_date' => 'date',
        'volume' => 'integer',
        'screening_results' => 'array',
    ];

    public function donor(): BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }


    public function distribution(): HasOne
    {
        return $this->hasOne(Distribution::class);
    }

    public function getDaysUntilExpiryAttribute(): int
    {
        return now()->diffInDays($this->expiry_date, false);
    }

    public function getIsNearExpiryAttribute(): bool
    {
        return $this->days_until_expiry <= 7 && $this->days_until_expiry > 0;
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->expiry_date->isPast();
    }

    public function updateStatusBasedOnExpiry(): void
    {
        if ($this->is_expired) {
            $this->status = 'Expired';
        } elseif ($this->is_near_expiry) {
            $this->status = 'Near Expiry';
        } elseif ($this->status === 'Near Expiry' && !$this->is_near_expiry) {
            $this->status = 'Available';
        }
        
        $this->save();
    }

    public function getScreeningStatusAttribute(): string
    {
        if (!$this->screening_results) {
            return 'Pending';
        }

        $results = $this->screening_results;
        $failed = false;

        foreach ($results as $test => $result) {
            if ($result === 'Positive' || $result === 'Reactive') {
                $failed = true;
                break;
            }
        }

        return $failed ? 'Failed' : 'Passed';
    }

    protected static function booted()
    {
        static::created(function ($bloodUnit) {
            $donor = $bloodUnit->donor;
            if ($donor) {
                $donor->update([
                    'last_donation_date' => $bloodUnit->collection_date,
                    'total_donations' => $donor->total_donations + 1,
                ]);
            }
        });
    }
}
