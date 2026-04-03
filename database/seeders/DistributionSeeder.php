<?php

namespace Database\Seeders;

use App\Models\Distribution;
use App\Models\BloodUnit;
use App\Models\Establishment;
use Illuminate\Database\Seeder;

class DistributionSeeder extends Seeder
{
    public function run(): void
    {
        $availableUnits = BloodUnit::where('status', 'Available')->get();
        $establishments = Establishment::all();

        if ($availableUnits->isEmpty()) {
            $this->command->info('No available blood units found.');
            return;
        }

        // Create some sample distributions
        for ($i = 0; $i < min(5, $availableUnits->count()); $i++) {
            $bloodUnit = $availableUnits->random();
            $establishment = $establishments->random();

            Distribution::create([
                'distribution_id' => 'DIST-' . str_pad(($i + 1), 4, '0', STR_PAD_LEFT),
                'blood_unit_id' => $bloodUnit->id,
                'department' => ['Emergency', 'Surgery', 'Maternity', 'ICU', 'Pediatrics', 'General Ward'][rand(0, 5)],
                'status' => 'Reserved',
                'purpose' => 'Emergency surgery',
                'patient_name' => 'Patient ' . ($i + 1),
                'patient_id' => 'PAT-' . str_pad(($i + 1), 4, '0', STR_PAD_LEFT),
                'reserved_until' => now()->addHours(24),
                'created_by' => 1, // Assuming user ID 1 exists
                'establishment_id' => $establishment->id,
            ]);

            // Update blood unit status
            $bloodUnit->update(['status' => 'Reserved']);
        }

        $this->command->info('Sample distributions created: ' . Distribution::count());
    }
}
