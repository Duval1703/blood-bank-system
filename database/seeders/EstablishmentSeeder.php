<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Establishment;
use Illuminate\Support\Facades\Hash;

class EstablishmentSeeder extends Seeder
{
    public function run(): void
    {
        $establishments = [
            [
                'name' => 'Central Blood Bank',
                'code' => 'CBB-001',
                'type' => 'Blood Bank',
                'address' => '123 Medical Center Drive',
                'city' => 'New York',
                'state' => 'NY',
                'zip_code' => '10001',
                'phone' => '(212) 555-0100',
                'email' => 'central@bloodbank.com',
                'contact_person' => 'Dr. Sarah Johnson',
                'is_active' => true,
            ],
            [
                'name' => 'General Hospital Blood Bank',
                'code' => 'GHB-001',
                'type' => 'Hospital',
                'address' => '456 Hospital Avenue',
                'city' => 'New York',
                'state' => 'NY',
                'zip_code' => '10002',
                'phone' => '(212) 555-0200',
                'email' => 'bloodbank@generalhospital.com',
                'contact_person' => 'Dr. Michael Chen',
                'is_active' => true,
            ],
            [
                'name' => 'Community Health Clinic',
                'code' => 'CHC-001',
                'type' => 'Clinic',
                'address' => '789 Health Street',
                'city' => 'Brooklyn',
                'state' => 'NY',
                'zip_code' => '11201',
                'phone' => '(718) 555-0300',
                'email' => 'contact@communityclinic.org',
                'contact_person' => 'Dr. Emily Rodriguez',
                'is_active' => true,
            ],
        ];

        foreach ($establishments as $establishment) {
            Establishment::create($establishment);
        }

        // Create a system admin user
        \App\Models\User::create([
            'name' => 'System Administrator',
            'email' => 'admin@bloodbank.com',
            'password' => Hash::make('password'),
            'role' => 'System Administrator',
            'phone' => '(212) 555-0000',
        ]);

        // Create blood bank managers for each establishment
        $centralBank = Establishment::where('name', 'Central Blood Bank')->first();
        $generalHospital = Establishment::where('name', 'General Hospital Blood Bank')->first();
        $communityClinic = Establishment::where('name', 'Community Health Clinic')->first();

        \App\Models\User::create([
            'name' => 'Central Bank Manager',
            'email' => 'manager@bloodbank.com',
            'password' => Hash::make('password'),
            'role' => 'Blood Bank Manager',
            'establishment_id' => $centralBank->id,
            'phone' => '(212) 555-0101',
        ]);

        \App\Models\User::create([
            'name' => 'Hospital Manager',
            'email' => 'hospital@bloodbank.com',
            'password' => Hash::make('password'),
            'role' => 'Blood Bank Manager',
            'establishment_id' => $generalHospital->id,
            'phone' => '(212) 555-0201',
        ]);

        \App\Models\User::create([
            'name' => 'Clinic Manager',
            'email' => 'clinic@bloodbank.com',
            'password' => Hash::make('password'),
            'role' => 'Blood Bank Manager',
            'establishment_id' => $communityClinic->id,
            'phone' => '(718) 555-0301',
        ]);
    }
}
