<?php

namespace Database\Seeders;

use App\Models\Laboratory;
use App\Models\LabRequest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;

class LabRequestSeeder extends Seeder
{
    public function run(): void
    {
        $patient = Patient::first();
        $user = User::first();

        if (!$patient || !$user) {
            $this->command->warn('No patients or users found. Run PatientSeeder and UsersSeeder first.');
            return;
        }

        $labTests = [
            ['name' => 'Full Blood Count', 'price' => 2500],
            ['name' => 'Malaria Parasite', 'price' => 1500],
            ['name' => 'Widal Test', 'price' => 2000],
            ['name' => 'Urinalysis', 'price' => 1800],
            ['name' => 'Fasting Blood Sugar', 'price' => 1200],
            ['name' => 'Random Blood Sugar', 'price' => 1000],
            ['name' => 'Liver Function Test', 'price' => 5000],
            ['name' => 'Kidney Function Test', 'price' => 4500],
            ['name' => 'Lipid Profile', 'price' => 6000],
            ['name' => 'Thyroid Function Test', 'price' => 7500],
            ['name' => 'HIV Screening', 'price' => 2000],
            ['name' => 'Hepatitis B Surface Antigen', 'price' => 2500],
            ['name' => 'Hepatitis C Antibody', 'price' => 2500],
            ['name' => 'Stool Microscopy', 'price' => 1500],
            ['name' => 'Blood Culture', 'price' => 8000],
            ['name' => 'Urine Culture', 'price' => 6000],
            ['name' => 'Semen Analysis', 'price' => 5000],
            ['name' => 'Pregnancy Test', 'price' => 1000],
            ['name' => 'ESR', 'price' => 1500],
            ['name' => 'CRP', 'price' => 3000],
        ];

        $statuses = ['Pending', 'Specimen Collected'];

        foreach ($labTests as $testData) {
            $lab = Laboratory::firstOrCreate(
                ['name' => $testData['name']],
                ['price' => $testData['price']]
            );

            LabRequest::create([
                'patient_id'   => $patient->id,
                'user_id'      => $user->id,
                'test_id'      => $lab->id,
                'request_note' => 'Seeded test request',
                'priority'     => 'Normal',
                'status'       => $statuses[array_rand($statuses)],
            ]);
        }

        $this->command->info('20 lab requests seeded successfully.');
    }
}
