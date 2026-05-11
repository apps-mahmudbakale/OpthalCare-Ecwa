<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\AntenatalRecord;
use App\Models\Billing;

class PatientRecordTrackerController extends Controller
{
    public function index()
    {
        return view('admin.patient-tracker.index');
    }

    public function trackPatient(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id'
        ]);

        $patientId = $request->patient_id;
        $patient = Patient::with('user')->find($patientId);
        
        $records = $this->getPatientRecordsFromAllTables($patientId);
        
        return view('admin.patient-tracker.results', compact('patient', 'records'));
    }

    public function recentActivity(Request $request)
    {
        $days = $request->get('days', 7);
        $startDate = now()->subDays($days);
        
        $patients = $this->getPatientsWithRecentActivity($startDate);
        
        return view('admin.patient-tracker.recent-activity', compact('patients', 'days'));
    }

    public function summary()
    {
        $summary = $this->getDatabaseSummary();
        return view('admin.patient-tracker.summary', compact('summary'));
    }

    public function exportPatientRecords($patientId)
    {
        $patient = Patient::with('user')->find($patientId);
        $records = $this->getPatientRecordsFromAllTables($patientId);
        
        $filename = "patient_{$patientId}_records_" . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($records) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Table', 'Record Count', 'Latest Record', 'Record Details']);
            
            foreach ($records as $record) {
                fputcsv($file, $record);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getPatientRecordsFromAllTables($patientId)
    {
        $records = [];

        // Antenatal Records
        $antenatalCount = AntenatalRecord::where('patient_id', $patientId)->count();
        if ($antenatalCount > 0) {
            $latest = AntenatalRecord::where('patient_id', $patientId)->latest()->first();
            $records[] = [
                'table' => 'antenatal_records',
                'count' => $antenatalCount,
                'latest' => $latest->created_at->format('Y-m-d H:i:s'),
                'details' => "Visit Type: {$latest->visit_type}, Status: " . ($latest->status ?? 'active'),
                'latest_id' => $latest->id
            ];
        }

        // Billings
        $billingCount = Billing::where('user_id', $patientId)->count();
        if ($billingCount > 0) {
            $latest = Billing::where('user_id', $patientId)->latest()->first();
            $records[] = [
                'table' => 'billings',
                'count' => $billingCount,
                'latest' => $latest->created_at->format('Y-m-d H:i:s'),
                'details' => "Service: {$latest->service}, Amount: ₦{$latest->amount}",
                'latest_id' => $latest->id
            ];
        }

        // Add more tables using raw queries
        $additionalTables = [
            'admissions' => 'patient_id',
            'check_ins' => 'patient_id',
            'drug_requests' => 'patient_id',
            'lab_requests' => 'patient_id',
            'radiology_requests' => 'patient_id',
            'procedure_requests' => 'patient_id',
            'diagnoses' => 'patient_id',
            'vitals' => 'patient_id'
        ];

        foreach ($additionalTables as $table => $column) {
            try {
                $count = DB::table($table)->where($column, $patientId)->count();
                if ($count > 0) {
                    $latest = DB::table($table)->where($column, $patientId)->latest()->first();
                    $records[] = [
                        'table' => $table,
                        'count' => $count,
                        'latest' => $latest->created_at ?? 'N/A',
                        'details' => "Records in {$table}",
                        'latest_id' => $latest->id ?? null
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
        $patients = collect();

        // Get patients from antenatal records
        $antenatalPatients = DB::table('antenatal_records')
            ->join('patients', 'antenatal_records.patient_id', '=', 'patients.id')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->where('antenatal_records.created_at', '>=', $startDate)
            ->select('patients.id', 'users.firstname', 'users.lastname', 'patients.hospital_no', 'antenatal_records.created_at as last_activity')
            ->orderBy('antenatal_records.created_at', 'desc')
            ->get();

        foreach ($antenatalPatients as $patient) {
            $patients->put($patient->id, [
                'id' => $patient->id,
                'name' => "{$patient->firstname} {$patient->lastname}",
                'hospital_no' => $patient->hospital_no ?? 'N/A',
                'last_activity' => $patient->last_activity,
                'activity_type' => 'Antenatal Record'
            ]);
        }

        // Get patients from billings
        $billingPatients = DB::table('billings')
            ->join('patients', 'billings.user_id', '=', 'patients.id')
            ->join('users', 'patients.user_id', '=', 'users.id')
            ->where('billings.created_at', '>=', $startDate)
            ->select('patients.id', 'users.firstname', 'users.lastname', 'patients.hospital_no', 'billings.created_at as last_activity')
            ->orderBy('billings.created_at', 'desc')
            ->get();

        foreach ($billingPatients as $patient) {
            if (!$patients->has($patient->id)) {
                $patients->put($patient->id, [
                    'id' => $patient->id,
                    'name' => "{$patient->firstname} {$patient->lastname}",
                    'hospital_no' => $patient->hospital_no ?? 'N/A',
                    'last_activity' => $patient->last_activity,
                    'activity_type' => 'Billing Record'
                ]);
            }
        }

        return $patients->values()->toArray();
    }

    private function getDatabaseSummary()
    {
        $tables = [
            'patients' => Patient::class,
            'antenatal_records' => AntenatalRecord::class,
            'billings' => Billing::class,
        ];

        $summary = [];
        foreach ($tables as $tableName => $model) {
            try {
                $count = $model::count();
                $latest = $model::latest()->first();
                $oldest = $model::oldest()->first();
                
                $summary[] = [
                    'table' => $tableName,
                    'count' => $count,
                    'latest' => $latest ? $latest->created_at->format('Y-m-d H:i:s') : 'N/A',
                    'oldest' => $oldest ? $oldest->created_at->format('Y-m-d H:i:s') : 'N/A'
                ];
            } catch (\Exception $e) {
                $summary[] = [
                    'table' => $tableName,
                    'count' => 'ERROR',
                    'latest' => $e->getMessage(),
                    'oldest' => 'N/A'
                ];
            }
        }

        // Add raw table queries
        $rawTables = ['admissions', 'check_ins', 'drug_requests', 'lab_requests', 'diagnoses', 'vitals'];
        
        foreach ($rawTables as $table) {
            try {
                $count = DB::table($table)->count();
                $latest = DB::table($table)->latest()->first();
                $oldest = DB::table($table)->oldest()->first();
                
                $summary[] = [
                    'table' => $table,
                    'count' => $count,
                    'latest' => $latest ? $latest->created_at : 'N/A',
                    'oldest' => $oldest ? $oldest->created_at : 'N/A'
                ];
            } catch (\Exception $e) {
                // Table might not exist
            }
        }

        return $summary;
    }
}
