<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ICD10Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = base_path('icd 11.csv');
        if (!file_exists($filePath)) {
            $this->command->error("File not found: $filePath");
            return;
        }

        $file = fopen($filePath, 'r');
        $batchSize = 1000;
        $batch = [];
        $count = 0;

        while (($data = fgetcsv($file)) !== false) {
            if (empty($data[0])) continue;

            $number = trim($data[0]);
            // Join subsequent non-empty columns as the name
            $nameParts = array_slice($data, 1);
            $nameParts = array_filter($nameParts, fn($part) => trim($part) !== '');
            $name = trim(implode(', ', $nameParts));

            $batch[] = [
                'number' => $number,
                'name' => $name,
                'group' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($batch) >= $batchSize) {
                DB::table('i_c_d10_s')->insert($batch);
                $batch = [];
                $count += $batchSize;
                $this->command->info("Seeded $count records...");
            }
        }

        if (!empty($batch)) {
            DB::table('i_c_d10_s')->insert($batch);
            $count += count($batch);
        }

        fclose($file);
        $this->command->info("Seeding complete. Total records: $count");
    }
}
