<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\AntenatalRecord;
use App\Models\Billing;
use App\Models\LabRequest;
use App\Models\Diagnosis;
use App\Models\Vitals;

class TrackPatientRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patient:track 
                            {--patient= : Specific patient ID to track}
                            {--days=7 : Number of days to look back for recent activity}
                            {--export : Export results to CSV}
                            {--summary : Show summary of all tables}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Track patient records across all tables to identify offline/online sync issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Patient Record Tracker');
        $this->info('====================');

        if ($this->option('summary')) {
            $this->showSummary();
            return;
        }

        if ($patientId = $this->option('patient')) {
            $this->trackSpecificPatient($patientId);
            return;
        }

        $days = $this->option('days');
        $this->trackRecentActivity($days);
    }

    private function showSummary()
    {
        $this->info('Database Summary:');
        
        $tables = [
            'patients' => Patient::class,
            'antenatal_records' => AntenatalRecord::class,
            'billings' => Billing::class,
            'lab_requests' => LabRequest::class,
            'diagnoses' => Diagnosis::class,
            'vitals' => Vitals::class,
        ];

        $data = [];
        foreach ($tables as $tableName => $model) {
            try {
                $count = $model::count();
                $latest = $model::latest()->first();
                $oldest = $model::oldest()->first();
                
                $data[] = [
                    'Table' => $tableName,
                    'Count' => $count,
                    'Latest Record' => $latest ? $latest->created_at->format('Y-m-d H:i:s') : 'N/A',
                    'Oldest Record' => $oldest ? $oldest->created_at->format('Y-m-d H:i:s') : 'N/A'
                ];
            } catch (\Exception $e) {
                $data[] = [
                    'Table' => $tableName,
                    'Count' => 'ERROR',
                    'Latest Record' => $e->getMessage(),
                    'Oldest Record' => 'N/A'
                ];
            }
        }

        $this->table(['Table', 'Count', 'Latest Record', 'Oldest Record'], $data);
    }

    private function trackSpecificPatient($patientId)
    {
        $patient = Patient::with('user')->find($patientId);
        
        if (!$patient) {
            $this->error("Patient with ID {$patientId} not found.");
            return;
        }

        $this->info("Tracking records for Patient ID: {$patientId}");
        $this->info("Patient Name: {$patient->user->firstname} {$patient->user->lastname}");
        $this->info("Hospital No: " . ($patient->hospital_no ?? 'N/A'));
        $this->line('');

        // Get records from all tables
        $records = $this->getPatientRecordsFromAllTables($patientId);
        
        if (empty($records)) {
            $this->warn('No records found for this patient.');
            return;
        }

        $this->table(['Table', 'Record Count', 'Latest Record', 'Record Details'], $records);

        if ($this->option('export')) {
            $this->exportPatientRecords($patientId, $records);
        }
    }

    private function trackRecentActivity($days)
    {
        $this->info("Tracking patient activity in the last {$days} days:");
        $this->line('');

        $startDate = now()->subDays($days);
        
        // Get patients with recent activity
        $recentPatients = $this->getPatientsWithRecentActivity($startDate);
        
        if (empty($recentPatients)) {
            $this->warn("No patient activity found in the last {$days} days.");
            return;
        }

        $this->info("Found " . count($recentPatients) . " patients with recent activity:");
        $this->table(['Patient ID', 'Name', 'Hospital No', 'Last Activity', 'Activity Type'], $recentPatients);

        if ($this->option('export')) {
            $this->exportRecentActivity($recentPatients);
        }
    }

    private function getPatientRecordsFromAllTables($patientId)
    {
        $records = [];

        // Antenatal Records
        $antenatalCount = AntenatalRecord::where('patient_id', $patientId)->count();
        if ($antenatalCount > 0) {
            $latest = AntenatalRecord::where('patient_id', $patientId)->latest()->first();
            $records[] = [
                'antenatal_records',
                $antenatalCount,
                $latest->created_at->format('Y-m-d H:i:s'),
                "Visit Type: {$latest->visit_type}, Status: " . ($latest->status ?? 'active')
            ];
        }

        // Billings
        $billingCount = Billing::where('user_id', $patientId)->count();
        if ($billingCount > 0) {
            $latest = Billing::where('user_id', $patientId)->latest()->first();
            $records[] = [
                'billings',
                $billingCount,
                $latest->created_at->format('Y-m-d H:i:s'),
                "Service: {$latest->service}, Amount: ₦{$latest->amount}"
            ];
        }

        // Lab Requests
        try {
            $labCount = LabRequest::where('patient_id', $patientId)->count();
            if ($labCount > 0) {
                $latest = LabRequest::where('patient_id', $patientId)->latest()->first();
                $records[] = [
                    'lab_requests',
                    $labCount,
                    $latest->created_at->format('Y-m-d H:i:s'),
                    "Status: " . ($latest->status ?? 'pending')
                ];
            }
        } catch (\Exception $e) {
            // Table might not exist or have different structure
        }

        // Diagnoses
        try {
            $diagnosisCount = Diagnosis::where('patient_id', $patientId)->count();
            if ($diagnosisCount > 0) {
                $latest = Diagnosis::where('patient_id', $patientId)->latest()->first();
                $records[] = [
                    'diagnoses',
                    $diagnosisCount,
                    $latest->created_at->format('Y-m-d H:i:s'),
                    "Diagnosis: " . ($latest->provisional_diagnosis ?? 'N/A')
                ];
            }
        } catch (\Exception $e) {
            // Table might not exist or have different structure
        }

        // Vitals
        try {
            $vitalsCount = Vitals::where('patient_id', $patientId)->count();
            if ($vitalsCount > 0) {
                $latest = Vitals::where('patient_id', $patientId)->latest()->first();
                $records[] = [
                    'vitals',
                    $vitalsCount,
                    $latest->created_at->format('Y-m-d H:i:s'),
                    "BP: " . ($latest->blood_pressure ?? 'N/A') . ", Temp: " . ($latest->temperature ?? 'N/A')
                ];
            }
        } catch (\Exception $e) {
            // Table might not exist or have different structure
        }

        // Add more tables using raw queries for tables without models
        $additionalTables = [
            'admissions' => 'patient_id',
            'check_ins' => 'patient_id',
            'drug_requests' => 'patient_id',
            'radiology_requests' => 'patient_id',
            'procedure_requests' => 'patient_id'
        ];

        foreach ($additionalTables as $table => $column) {
            try {
                $count = DB::table($table)->where($column, $patientId)->count();
                if ($count > 0) {
                    $latest = DB::table($table)->where($column, $patientId)->latest()->first();
                    $records[] = [
                        $table,
                        $count,
                        $latest->created_at ?? 'N/A',
                        "Raw record from {$table}"
                    ];
                }
            } catch (\Exception $e) {
                // Table might not exist
            }
        }

        return $records;
    }

    private function getPatientsWithRecentActivity($startDate)
    {
        $patients = [];

        // Get patients from antenatal records
        $antenatalPatients = DB::table('antenatal_records')
            ->join('patients', 'antenatal_records.patient_id', '=', 'patients.id')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->where('antenatal_records.created_at', '>=', $startDate)
            ->select('patients.id', 'users.firstname', 'users.lastname', 'patients.hospital_no', 'antenatal_records.created_at as last_activity')
            ->get();

        foreach ($antenatalPatients as $patient) {
            $patients[$patient->id] = [
                $patient->id,
                "{$patient->firstname} {$patient->lastname}",
                $patient->hospital_no ?? 'N/A',
                $patient->last_activity,
                'Antenatal Record'
            ];
        }

        // Get patients from billings
        $billingPatients = DB::table('billings')
            ->join('patients', 'billings.user_id', '=', 'patients.id')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->where('billings.created_at', '>=', $startDate)
            ->select('patients.id', 'users.firstname', 'users.lastname', 'patients.hospital_no', 'billings.created_at as last_activity')
            ->get();

        foreach ($billingPatients as $patient) {
            if (!isset($patients[$patient->id])) {
                $patients[$patient->id] = [
                    $patient->id,
                    "{$patient->firstname} {$patient->lastname}",
                    $patient->hospital_no ?? 'N/A',
                    $patient->last_activity,
                    'Billing Record'
                ];
            }
        }

        return array_values($patients);
    }

    private function exportPatientRecords($patientId, $records)
    {
        $filename = "patient_{$patientId}_records_" . date('Y-m-d_H-i-s') . '.csv';
        $filepath = storage_path("app/{$filename}");

        $file = fopen($filepath, 'w');
        fputcsv($file, ['Table', 'Record Count', 'Latest Record', 'Record Details']);

        foreach ($records as $record) {
            fputcsv($file, $record);
        }

        fclose($file);
        $this->info("Patient records exported to: {$filepath}");
    }

    private function exportRecentActivity($patients)
    {
        $filename = "recent_patient_activity_" . date('Y-m-d_H-i-s') . '.csv';
        $filepath = storage_path("app/{$filename}");

        $file = fopen($filepath, 'w');
        fputcsv($file, ['Patient ID', 'Name', 'Hospital No', 'Last Activity', 'Activity Type']);

        foreach ($patients as $patient) {
            fputcsv($file, $patient);
        }

        fclose($file);
        $this->info("Recent activity exported to: {$filepath}");
    }
}
