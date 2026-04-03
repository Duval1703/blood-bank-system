<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Establishment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type',
        'address',
        'city',
        'state',
        'zip_code',
        'phone',
        'email',
        'contact_person',
        'is_active',
        'inventory_visible',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'inventory_visible' => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function donors(): HasMany
    {
        return $this->hasMany(Donor::class);
    }

    public function bloodUnits(): HasMany
    {
        return $this->hasMany(BloodUnit::class);
    }

    public function distributions(): HasMany
    {
        return $this->hasMany(Distribution::class);
    }

    public function alerts(): HasMany
    {
        return $this->hasMany(Alert::class);
    }

    public function getBloodTypeStockAttribute(): array
    {
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        $stock = [];

        foreach ($bloodTypes as $type) {
            $available = $this->bloodUnits()
                ->where('blood_type', $type)
                ->where('status', 'Available')
                ->count();

            $reserved = $this->bloodUnits()
                ->where('blood_type', $type)
                ->where('status', 'Reserved')
                ->count();

            $nearExpiry = $this->bloodUnits()
                ->where('blood_type', $type)
                ->where('status', 'Near Expiry')
                ->count();

            $stock[$type] = [
                'available' => $available,
                'reserved' => $reserved,
                'near_expiry' => $nearExpiry,
                'total' => $available + $reserved + $nearExpiry,
            ];
        }

        return $stock;
    }
}
