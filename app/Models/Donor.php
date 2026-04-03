<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donor extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_id_code',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'phone',
        'email',
        'address',
        'occupation',
        'blood_type',
        'medical_conditions',
        'current_medications',
        'allergies',
        'is_eligible',
        'last_donation_date',
        'total_donations',
        'weight',
        'notes',
        'establishment_id',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'last_donation_date' => 'date',
        'is_eligible' => 'boolean',
        'total_donations' => 'integer',
        'weight' => 'decimal:2',
    ];


    public function bloodUnits(): HasMany
    {
        return $this->hasMany(BloodUnit::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAgeAttribute(): int
    {
        return $this->date_of_birth->age;
    }

    public function isEligibleToDonate(): bool
    {
        if (!$this->is_eligible) {
            return false;
        }

        if ($this->last_donation_date) {
            $eightWeeksAgo = now()->subWeeks(8);
            return $this->last_donation_date->lessThan($eightWeeksAgo);
        }

        return true;
    }

    public function getNextEligibleDateAttribute(): ?\Carbon\Carbon
    {
        if ($this->last_donation_date) {
            return \Carbon\Carbon::parse($this->last_donation_date)->addWeeks(8);
        }

        return null;
    }

    public function getScreeningResultsAttribute(): array
    {
        $results = [];
        
        foreach ($this->bloodUnits as $unit) {
            if ($unit->screening_results) {
                $screening = json_decode($unit->screening_results, true);
                if ($screening) {
                    $results[] = [
                        'unit_number' => $unit->unit_number,
                        'collection_date' => $unit->collection_date,
                        'results' => $screening,
                    ];
                }
            }
        }

        return $results;
    }

    public static function generateDonorIdCode(): string
    {
        do {
            $code = 'DON-' . str_pad(random_int(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (self::where('donor_id_code', $code)->exists());
        
        return $code;
    }

    protected static function booted()
    {
        static::created(function ($donor) {
            if (empty($donor->donor_id_code)) {
                $donor->update(['donor_id_code' => self::generateDonorIdCode()]);
            }
        });
    }
}
