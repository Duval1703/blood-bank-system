<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Donor;
use App\Models\Establishment;

class DonorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $establishment = Establishment::first();
        
        if (!$establishment) {
            $this->command->warn('No establishment found. Please create an establishment first.');
            return;
        }

        $donors = [
            [
                'first_name' => 'John',
                'last_name' => 'Smith',
                'date_of_birth' => '1990-05-15',
                'gender' => 'Male',
                'phone' => '+1-555-0101',
                'email' => 'john.smith@email.com',
                'address' => '123 Main Street, Apt 4B',
                'occupation' => 'Software Engineer',
                'blood_type' => 'O+',
                'medical_conditions' => 'None',
                'current_medications' => 'None',
                'allergies' => 'Penicillin',
                'is_eligible' => true,
                'weight' => 75.5,
                'notes' => 'Regular donor, last donated 3 months ago',
                'establishment_id' => $establishment->id,
                'total_donations' => 8,
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Johnson',
                'date_of_birth' => '1985-08-22',
                'gender' => 'Female',
                'phone' => '+1-555-0102',
                'email' => 'sarah.johnson@email.com',
                'address' => '456 Oak Avenue, House 12',
                'occupation' => 'Teacher',
                'blood_type' => 'A+',
                'medical_conditions' => 'None',
                'current_medications' => 'Vitamin D supplements',
                'allergies' => 'None',
                'is_eligible' => true,
                'weight' => 62.0,
                'notes' => 'First-time donor, nervous but motivated',
                'establishment_id' => $establishment->id,
                'total_donations' => 0,
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Brown',
                'date_of_birth' => '1978-03-10',
                'gender' => 'Male',
                'phone' => '+1-555-0103',
                'email' => 'michael.brown@email.com',
                'address' => '789 Pine Road, Unit 5',
                'occupation' => 'Construction Worker',
                'blood_type' => 'B-',
                'medical_conditions' => 'Hypertension (controlled)',
                'current_medications' => 'Blood pressure medication',
                'allergies' => 'None',
                'is_eligible' => false,
                'weight' => 85.0,
                'notes' => 'Temporarily ineligible due to medication, follow up in 2 weeks',
                'establishment_id' => $establishment->id,
                'total_donations' => 15,
            ],
            [
                'first_name' => 'Emily',
                'last_name' => 'Davis',
                'date_of_birth' => '1995-12-03',
                'gender' => 'Female',
                'phone' => '+1-555-0104',
                'email' => 'emily.davis@email.com',
                'address' => '321 Elm Street, Apartment 2C',
                'occupation' => 'Nurse',
                'blood_type' => 'AB+',
                'medical_conditions' => 'None',
                'current_medications' => 'None',
                'allergies' => 'Latex',
                'is_eligible' => true,
                'weight' => 58.5,
                'notes' => 'Medical professional, understands donation process well',
                'establishment_id' => $establishment->id,
                'total_donations' => 3,
            ],
            [
                'first_name' => 'Robert',
                'last_name' => 'Wilson',
                'date_of_birth' => '1982-07-18',
                'gender' => 'Male',
                'phone' => '+1-555-0105',
                'email' => 'robert.wilson@email.com',
                'address' => '654 Maple Drive, House 8',
                'occupation' => 'Firefighter',
                'blood_type' => 'O-',
                'medical_conditions' => 'None',
                'current_medications' => 'None',
                'allergies' => 'None',
                'is_eligible' => true,
                'weight' => 80.0,
                'notes' => 'Universal donor, emergency response worker',
                'establishment_id' => $establishment->id,
                'total_donations' => 12,
            ],
            [
                'first_name' => 'Lisa',
                'last_name' => 'Martinez',
                'date_of_birth' => '1992-11-25',
                'gender' => 'Female',
                'phone' => '+1-555-0106',
                'email' => 'lisa.martinez@email.com',
                'address' => '987 Cedar Lane, Apt 1A',
                'occupation' => 'College Student',
                'blood_type' => 'A-',
                'medical_conditions' => 'Mild asthma',
                'current_medications' => 'Inhaler (as needed)',
                'allergies' => 'Pollen',
                'is_eligible' => true,
                'weight' => 55.0,
                'notes' => 'Student, motivated to help community',
                'establishment_id' => $establishment->id,
                'total_donations' => 1,
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Taylor',
                'date_of_birth' => '1975-01-30',
                'gender' => 'Male',
                'phone' => '+1-555-0107',
                'email' => 'david.taylor@email.com',
                'address' => '246 Birch Boulevard, Suite 300',
                'occupation' => 'Accountant',
                'blood_type' => 'B+',
                'medical_conditions' => 'Type 2 Diabetes (controlled)',
                'current_medications' => 'Metformin',
                'allergies' => 'Sulfa drugs',
                'is_eligible' => false,
                'weight' => 90.0,
                'notes' => 'Ineligible due to diabetes medication, seeking alternative',
                'establishment_id' => $establishment->id,
                'total_donations' => 20,
            ],
            [
                'first_name' => 'Jennifer',
                'last_name' => 'Anderson',
                'date_of_birth' => '1988-09-14',
                'gender' => 'Female',
                'phone' => '+1-555-0108',
                'email' => 'jennifer.anderson@email.com',
                'address' => '135 Spruce Street, House 15',
                'occupation' => 'Graphic Designer',
                'blood_type' => 'AB-',
                'medical_conditions' => 'None',
                'current_medications' => 'Birth control pills',
                'allergies' => 'None',
                'is_eligible' => true,
                'weight' => 64.0,
                'notes' => 'Creative professional, regular donor',
                'establishment_id' => $establishment->id,
                'total_donations' => 5,
            ],
            [
                'first_name' => 'James',
                'last_name' => 'Thomas',
                'date_of_birth' => '1993-06-08',
                'gender' => 'Male',
                'phone' => '+1-555-0109',
                'email' => 'james.thomas@email.com',
                'address' => '868 Willow Way, Apartment 7B',
                'occupation' => 'Delivery Driver',
                'blood_type' => 'O+',
                'medical_conditions' => 'None',
                'current_medications' => 'None',
                'allergies' => 'Bee stings',
                'is_eligible' => true,
                'weight' => 70.0,
                'notes' => 'Young donor, enthusiastic about helping',
                'establishment_id' => $establishment->id,
                'total_donations' => 2,
            ],
        ];

        foreach ($donors as $donorData) {
            Donor::create($donorData);
        }

        $this->command->info('Donors seeded successfully!');
    }
}
