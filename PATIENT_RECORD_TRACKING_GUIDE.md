# Patient Record Tracking Guide

This guide provides comprehensive tools to track patient records across all tables in your healthcare system. Use these tools to identify records that were saved offline and need to be synchronized online.

## 🚀 Quick Start

### 1. Laravel Artisan Command (Recommended)

The easiest way to track patient records is using the Laravel Artisan command:

```bash
# Show database summary
php artisan patient:track --summary

# Track a specific patient
php artisan patient:track --patient=123

# Find patients with activity in last 7 days
php artisan patient:track --days=7

# Export results to CSV
php artisan patient:track --patient=123 --export
php artisan patient:track --days=7 --export
```

### 2. Direct SQL Queries

Use the `patient_record_tracker.sql` file for direct database queries:

```sql
-- Replace {PATIENT_ID} with actual patient ID
-- Replace {START_DATE} and {END_DATE} with date range
-- Replace {DAYS} with number of days

-- Example: Track patient ID 123
SELECT * FROM patients WHERE id = 123;
-- Then use the queries in the SQL file
```

### 3. PHP Script (For External Use)

Use `patient_record_tracker.php` for standalone PHP execution:

```bash
php patient_record_tracker.php
```

## 📊 Available Tools

### 1. Database Summary
Shows record counts and date ranges for all tables:
```bash
php artisan patient:track --summary
```

**Output:**
- Total records per table
- Latest record date
- Oldest record date
- Identifies missing or empty tables

### 2. Patient-Specific Tracking
Track all records for a specific patient:
```bash
php artisan patient:track --patient=123
```

**Shows:**
- Patient information (name, hospital number)
- Records in each table
- Latest record dates
- Record details and status

### 3. Recent Activity Tracking
Find patients with recent activity:
```bash
php artisan patient:track --days=30
```

**Identifies:**
- Patients with records in the last N days
- Type of activity (antenatal, billing, lab, etc.)
- Last activity date
- Helps find recently active patients

### 4. Export Functionality
Export results to CSV for analysis:
```bash
php artisan patient:track --patient=123 --export
php artisan patient:track --days=7 --export
```

**Files saved to:** `storage/app/`

## 🔍 Tables Tracked

The system tracks patient records across these tables:

### Primary Patient Tables
- `patients` - Patient demographics
- `antenatal_records` - Antenatal visits and records
- `billings` - Patient billing records

### Medical Records
- `diagnoses` - Patient diagnoses
- `vitals` - Vital signs
- `lab_requests` - Laboratory test requests
- `lab_results` - Laboratory test results
- `radiology_requests` - Radiology/imaging requests
- `radiology_results` - Radiology/imaging results
- `procedure_requests` - Medical procedure requests
- `drug_requests` - Medication requests

### Administrative Records
- `admissions` - Hospital admissions
- `check_ins` - Patient check-ins
- `appointments` - Scheduled appointments
- `allergies` - Patient allergies
- `vision_acuities` - Eye test results
- `optical_requests` - Optical/eye care requests

## 🔧 Offline/Online Synchronization

### Step 1: Identify Missing Records
```bash
# Check recent activity on offline database
php artisan patient:track --days=7

# Compare with online database
# Run the same command on online system
```

### Step 2: Find Specific Patient Records
```bash
# Get all records for patients found in step 1
php artisan patient:track --patient=123 --export
```

### Step 3: Export and Compare
```bash
# Export offline records
php artisan patient:track --days=30 --export

# Compare CSV files between offline and online systems
```

## 📝 SQL Query Examples

### Find All Records for Patient ID 123
```sql
-- Patient Info
SELECT p.*, CONCAT(u.firstname, ' ', u.lastname) as full_name 
FROM patients p 
JOIN users u ON p.user_id = u.id 
WHERE p.id = 123;

-- Antenatal Records
SELECT * FROM antenatal_records WHERE patient_id = 123 ORDER BY created_at DESC;

-- Billing Records
SELECT * FROM billings WHERE user_id = 123 ORDER BY created_at DESC;

-- Lab Requests
SELECT * FROM lab_requests WHERE patient_id = 123 ORDER BY created_at DESC;
```

### Find Records by Date Range
```sql
-- Records created in last 24 hours
SELECT 'antenatal_records' as table_name, id, patient_id, created_at 
FROM antenatal_records 
WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 DAY)

UNION ALL

SELECT 'billings' as table_name, id, user_id as patient_id, created_at 
FROM billings 
WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 DAY)

ORDER BY created_at DESC;
```

### Compare Record Counts
```sql
-- Get summary of all tables
SELECT 
    'patients' as table_name, COUNT(*) as count, MAX(created_at) as latest
FROM patients
UNION ALL
SELECT 'antenatal_records', COUNT(*), MAX(created_at) FROM antenatal_records
UNION ALL
SELECT 'billings', COUNT(*), MAX(created_at) FROM billings
UNION ALL
SELECT 'lab_requests', COUNT(*), MAX(created_at) FROM lab_requests;
```

## 🚨 Common Use Cases

### 1. System Went Offline - Find What Was Missed
```bash
# Find all activity since system went offline
php artisan patient:track --days=1  # if offline for 1 day

# Export for detailed analysis
php artisan patient:track --days=1 --export
```

### 2. Patient Claims Missing Records
```bash
# Check all records for the patient
php artisan patient:track --patient=123

# Export their complete record history
php artisan patient:track --patient=123 --export
```

### 3. Data Audit - Compare Databases
```bash
# On offline system
php artisan patient:track --summary > offline_summary.txt

# On online system  
php artisan patient:track --summary > online_summary.txt

# Compare the files
```

### 4. Find Recently Active Patients
```bash
# Last week's activity
php artisan patient:track --days=7

# Last month's activity
php artisan patient:track --days=30
```

## 📁 File Locations

- **SQL File:** `patient_record_tracker.sql`
- **PHP Script:** `patient_record_tracker.php`
- **Laravel Command:** `app/Console/Commands/TrackPatientRecords.php`
- **Controller:** `app/Http/Controllers/PatientRecordTrackerController.php`
- **Exports:** `storage/app/` (CSV files)

## 🔒 Security Notes

- Always backup databases before running synchronization
- Test queries on a copy of the database first
- Verify patient privacy compliance when exporting data
- Use secure connections when transferring data between systems

## 🆘 Troubleshooting

### Command Not Found
```bash
# Clear Laravel cache
php artisan config:clear
php artisan cache:clear
```

### Table Doesn't Exist Error
- Some tables might not exist in your database
- The command will skip missing tables automatically
- Check the error message for specific table names

### Permission Errors
- Ensure proper database permissions
- Check file write permissions for exports
- Verify Laravel storage directory permissions

## 📞 Support

If you encounter issues:
1. Check the Laravel logs: `storage/logs/laravel.log`
2. Verify database connections
3. Ensure all required tables exist
4. Check file permissions for exports

---

**Last Updated:** May 10, 2026
**Version:** 1.0