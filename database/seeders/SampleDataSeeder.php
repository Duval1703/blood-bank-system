<?php

namespace Database\Seeders;

use App\Models\BloodUnit;
use App\Models\Donor;
use App\Models\Alert;
use App\Models\Distribution;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create default user if not exists
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'System Administrator',
                'email_verified_at' => now(),
            ]
        );
        
        $this->command->info('Creating sample donors...');
        
        // Get establishments for assigning donors
        $establishments = \App\Models\Establishment::all();
        if ($establishments->isEmpty()) {
            $this->command->error('No establishments found. Please run EstablishmentSeeder first.');
            return;
        }
        
        // Create sample donors with diverse blood types
        $donors = [
            ['first_name' => 'John', 'last_name' => 'Smith', 'blood_type' => 'O+', 'email' => 'john.smith@email.com', 'gender' => 'Male'],
            ['first_name' => 'Jane', 'last_name' => 'Doe', 'blood_type' => 'A+', 'email' => 'jane.doe@email.com', 'gender' => 'Female'],
            ['first_name' => 'Robert', 'last_name' => 'Johnson', 'blood_type' => 'B-', 'email' => 'robert.j@email.com', 'gender' => 'Male'],
            ['first_name' => 'Mary', 'last_name' => 'Williams', 'blood_type' => 'AB+', 'email' => 'mary.w@email.com', 'gender' => 'Female'],
            ['first_name' => 'James', 'last_name' => 'Brown', 'blood_type' => 'O-', 'email' => 'james.brown@email.com', 'gender' => 'Male'],
            ['first_name' => 'Patricia', 'last_name' => 'Garcia', 'blood_type' => 'A-', 'email' => 'patricia.g@email.com', 'gender' => 'Female'],
            ['first_name' => 'Michael', 'last_name' => 'Martinez', 'blood_type' => 'B+', 'email' => 'michael.m@email.com', 'gender' => 'Male'],
            ['first_name' => 'Linda', 'last_name' => 'Rodriguez', 'blood_type' => 'AB-', 'email' => 'linda.r@email.com', 'gender' => 'Female'],
            ['first_name' => 'David', 'last_name' => 'Wilson', 'blood_type' => 'O+', 'email' => 'david.w@email.com', 'gender' => 'Male'],
            ['first_name' => 'Sarah', 'last_name' => 'Anderson', 'blood_type' => 'A+', 'email' => 'sarah.a@email.com', 'gender' => 'Female'],
        ];

        $createdDonors = [];
        foreach ($donors as $donorData) {
            $donor = Donor::create([
                'first_name' => $donorData['first_name'],
                'last_name' => $donorData['last_name'],
                'blood_type' => $donorData['blood_type'],
                'email' => $donorData['email'],
                'gender' => $donorData['gender'],
                'phone' => '555-0' . rand(100, 999),
                'date_of_birth' => now()->subYears(rand(25, 55))->format('Y-m-d'),
                'address' => rand(100, 999) . ' ' . ['Main St', 'Oak Ave', 'Elm St', 'Park Blvd'][array_rand(['Main St', 'Oak Ave', 'Elm St', 'Park Blvd'])],
                'city' => ['New York', 'Los Angeles', 'Chicago', 'Houston'][array_rand(['New York', 'Los Angeles', 'Chicago', 'Houston'])],
                'state' => ['NY', 'CA', 'IL', 'TX'][array_rand(['NY', 'CA', 'IL', 'TX'])],
                'zip_code' => rand(10000, 99999),
                'occupation' => ['Teacher', 'Engineer', 'Nurse', 'Developer', 'Designer'][array_rand(['Teacher', 'Engineer', 'Nurse', 'Developer', 'Designer'])],
                'is_eligible' => rand(0, 10) > 1, // 90% eligible
                'last_donation_date' => now()->subDays(rand(60, 365))->format('Y-m-d'),
                'total_donations' => 0,
                'weight' => rand(55, 95) + (rand(0, 99) / 100),
                'establishment_id' => $establishments->random()->id,
            ]);
            $createdDonors[] = $donor;
        }

        $this->command->info('Created ' . count($createdDonors) . ' donors.');
        $this->command->info('Creating blood units...');

        // Create blood units for donors
        $bloodUnits = [];
        foreach ($createdDonors as $donor) {
            // Create 2-4 blood units for each donor
            for ($i = 0; $i < rand(2, 4); $i++) {
                $collectionDate = now()->subDays(rand(1, 35));
                $expiryDate = $collectionDate->copy()->addDays(42);
                
                $unit = BloodUnit::create([
                    'unit_number' => 'BU' . now()->format('Y') . str_pad(BloodUnit::count() + 1, 6, '0', STR_PAD_LEFT),
                    'blood_type' => $donor->blood_type,
                    'status' => $this->getBloodUnitStatus($expiryDate),
                    'collection_date' => $collectionDate->format('Y-m-d'),
                    'expiry_date' => $expiryDate->format('Y-m-d'),
                    'volume' => rand(400, 500),
                    'donor_id' => $donor->id,
                    'establishment_id' => $donor->establishment_id,
                    'screening_results' => [
                        'HIV' => 'Negative',
                        'Hepatitis B' => 'Negative',
                        'Hepatitis C' => 'Negative',
                        'Syphilis' => 'Negative',
                    ],
                ]);
                $bloodUnits[] = $unit;
            }
        }

        $this->command->info('Created ' . count($bloodUnits) . ' blood units.');
        $this->command->info('Creating sample distributions...');

        // Create some distributions
        $departments = ['Emergency', 'Surgery', 'ICU', 'Maternity', 'General Ward'];
        $availableUnits = BloodUnit::where('status', 'Available')->limit(5)->get();
        
        foreach ($availableUnits as $index => $unit) {
            Distribution::create([
                'distribution_id' => 'DIST-' . str_pad($index + 1, 6, '0', STR_PAD_LEFT),
                'blood_unit_id' => $unit->id,
                'department' => $departments[array_rand($departments)],
                'purpose' => ['Transfusion', 'Surgery', 'Emergency', 'Treatment'][array_rand(['Transfusion', 'Surgery', 'Emergency', 'Treatment'])],
                'patient_name' => 'Patient ' . chr(65 + $index),
                'patient_id' => 'P' . rand(1000, 9999),
                'status' => ['Reserved', 'Issued'][array_rand(['Reserved', 'Issued'])],
                'created_by' => $user->id,
                'establishment_id' => $unit->establishment_id,
            ]);
        }

        $this->command->info('Created ' . Distribution::count() . ' distributions.');
        $this->command->info('Creating alerts...');

        // Create sample alerts
        Alert::createCriticalStockAlert('AB-', 2, 5);
        Alert::createLowStockAlert('O-', 8, 10);
        Alert::createExpiringSoonAlert('A+', 3);

        $this->command->info('Created ' . Alert::count() . ' alerts.');
        $this->command->info('Sample data seeded successfully!');
    }

    private function getBloodUnitStatus($expiryDate)
    {
        $daysUntilExpiry = now()->diffInDays($expiryDate, false);
        
        if ($daysUntilExpiry < 0) {
            return 'Expired';
        } elseif ($daysUntilExpiry <= 7) {
            return 'Near Expiry';
        } else {
            return 'Available';
        }
    }
}
