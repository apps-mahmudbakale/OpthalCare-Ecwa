<?php
/**
 * Patient Record Tracker Script
 * 
 * This script helps track patient records across all tables
 * Use this to identify records that might have been saved offline
 * and need to be synchronized online
 */

// Database configuration - Update these for your offline database
$offline_db = [
    'host' => 'localhost',
    'database' => 'vital_care_offline',
    'username' => 'root',
    'password' => ''
];

$online_db = [
    'host' => 'localhost', 
    'database' => 'vital_care_online',
    'username' => 'root',
    'password' => ''
];

class PatientRecordTracker {
    private $offline_pdo;
    private $online_pdo;
    
    public function __construct($offline_config, $online_config) {
        try {
            $this->offline_pdo = new PDO(
                "mysql:host={$offline_config['host']};dbname={$offline_config['database']}", 
                $offline_config['username'], 
                $offline_config['password']
            );
            
            $this->online_pdo = new PDO(
                "mysql:host={$online_config['host']};dbname={$online_config['database']}", 
                $online_config['username'], 
                $online_config['password']
            );
            
            $this->offline_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->online_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    /**
     * Get all records for a specific patient
     */
    public function getPatientRecords($patient_id, $database = 'offline') {
        $pdo = $database === 'offline' ? $this->offline_pdo : $this->online_pdo;
        
        $tables = [
            'antenatal_records' => 'patient_id',
            'billings' => 'user_id',
            'lab_requests' => 'patient_id',
            'diagnoses' => 'patient_id',
            'vitals' => 'patient_id',
            'admissions' => 'patient_id',
            'check_ins' => 'patient_id',
            'drug_requests' => 'patient_id',
            'radiology_requests' => 'patient_id'
        ];
        
        $results = [];
        
        foreach ($tables as $table => $column) {
            try {
                $stmt = $pdo->prepare("SELECT * FROM {$table} WHERE {$column} = ?");
                $stmt->execute([$patient_id]);
                $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if (!empty($records)) {
                    $results[$table] = $records;
                }
            } catch(PDOException $e) {
                echo "Error querying {$table}: " . $e->getMessage() . "\n";
            }
        }
        
        return $results;
    }
    
    /**
     * Compare record counts between offline and online databases
     */
    public function compareRecordCounts() {
        $tables = [
            'patients', 'antenatal_records', 'billings', 'lab_requests', 
            'diagnoses', 'vitals', 'admissions', 'check_ins'
        ];
        
        $comparison = [];
        
        foreach ($tables as $table) {
            try {
                // Offline count
                $stmt = $this->offline_pdo->query("SELECT COUNT(*) as count FROM {$table}");
                $offline_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
                
                // Online count
                $stmt = $this->online_pdo->query("SELECT COUNT(*) as count FROM {$table}");
                $online_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
                
                $comparison[$table] = [
                    'offline' => $offline_count,
                    'online' => $online_count,
                    'difference' => $offline_count - $online_count
                ];
                
            } catch(PDOException $e) {
                $comparison[$table] = ['error' => $e->getMessage()];
            }
        }
        
        return $comparison;
    }
    
    /**
     * Find records created in a date range
     */
    public function getRecordsByDateRange($start_date, $end_date, $database = 'offline') {
        $pdo = $database === 'offline' ? $this->offline_pdo : $this->online_pdo;
        
        $tables = [
            'antenatal_records' => 'patient_id',
            'billings' => 'user_id',
            'lab_requests' => 'patient_id',
            'diagnoses' => 'patient_id'
        ];
        
        $results = [];
        
        foreach ($tables as $table => $patient_column) {
            try {
                $sql = "SELECT *, '{$table}' as source_table FROM {$table} 
                        WHERE created_at BETWEEN ? AND ? 
                        ORDER BY created_at DESC";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$start_date, $end_date]);
                $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                $results[$table] = $records;
                
            } catch(PDOException $e) {
                echo "Error querying {$table}: " . $e->getMessage() . "\n";
            }
        }
        
        return $results;
    }
    
    /**
     * Find patients with recent activity
     */
    public function getPatientsWithRecentActivity($days = 7, $database = 'offline') {
        $pdo = $database === 'offline' ? $this->offline_pdo : $this->online_pdo;
        
        $sql = "
            SELECT DISTINCT 
                p.id as patient_id,
                CONCAT(u.firstname, ' ', u.lastname) as patient_name,
                p.hospital_no,
                p.created_at as patient_created
            FROM patients p
            JOIN users u ON p.user_id = u.id
            WHERE p.id IN (
                SELECT DISTINCT patient_id FROM antenatal_records 
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
                UNION
                SELECT DISTINCT user_id FROM billings 
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY) AND user_id IS NOT NULL
                UNION
                SELECT DISTINCT patient_id FROM lab_requests 
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
                UNION
                SELECT DISTINCT patient_id FROM diagnoses 
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
            )
            ORDER BY p.created_at DESC
        ";
        
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$days, $days, $days, $days]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage() . "\n";
            return [];
        }
    }
    
    /**
     * Export results to CSV
     */
    public function exportToCSV($data, $filename) {
        $file = fopen($filename, 'w');
        
        if (!empty($data)) {
            // Write headers
            fputcsv($file, array_keys($data[0]));
            
            // Write data
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
        }
        
        fclose($file);
        echo "Data exported to {$filename}\n";
    }
}

// Usage Examples:
echo "Patient Record Tracker\n";
echo "=====================\n\n";

try {
    $tracker = new PatientRecordTracker($offline_db, $online_db);
    
    // 1. Compare record counts
    echo "1. Comparing record counts between databases:\n";
    $comparison = $tracker->compareRecordCounts();
    foreach ($comparison as $table => $counts) {
        if (isset($counts['error'])) {
            echo "   {$table}: ERROR - {$counts['error']}\n";
        } else {
            echo "   {$table}: Offline={$counts['offline']}, Online={$counts['online']}, Diff={$counts['difference']}\n";
        }
    }
    echo "\n";
    
    // 2. Find patients with recent activity (last 7 days)
    echo "2. Patients with activity in last 7 days (offline):\n";
    $recent_patients = $tracker->getPatientsWithRecentActivity(7, 'offline');
    foreach ($recent_patients as $patient) {
        echo "   ID: {$patient['patient_id']}, Name: {$patient['patient_name']}, Hospital No: {$patient['hospital_no']}\n";
    }
    echo "\n";
    
    // 3. Get records for a specific patient (example with patient ID 1)
    if (!empty($recent_patients)) {
        $patient_id = $recent_patients[0]['patient_id'];
        echo "3. Records for Patient ID {$patient_id} (offline):\n";
        $patient_records = $tracker->getPatientRecords($patient_id, 'offline');
        foreach ($patient_records as $table => $records) {
            echo "   {$table}: " . count($records) . " records\n";
        }
        echo "\n";
    }
    
    // 4. Find records from last 24 hours
    echo "4. Records created in last 24 hours (offline):\n";
    $yesterday = date('Y-m-d H:i:s', strtotime('-24 hours'));
    $now = date('Y-m-d H:i:s');
    $recent_records = $tracker->getRecordsByDateRange($yesterday, $now, 'offline');
    
    $total_recent = 0;
    foreach ($recent_records as $table => $records) {
        $count = count($records);
        $total_recent += $count;
        if ($count > 0) {
            echo "   {$table}: {$count} records\n";
        }
    }
    echo "   Total recent records: {$total_recent}\n\n";
    
    // Export recent patients to CSV
    if (!empty($recent_patients)) {
        $tracker->exportToCSV($recent_patients, 'recent_patients_offline.csv');
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "Script completed.\n";
?>