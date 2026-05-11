-- =====================================================
-- PATIENT RECORD TRACKER ACROSS ALL TABLES
-- =====================================================
-- This script helps track patient records across all tables
-- Use this to identify records that might have been saved offline
-- and need to be synchronized online

-- =====================================================
-- 1. PATIENT SUMMARY QUERY
-- =====================================================
-- Get a complete overview of a specific patient's records across all tables
-- Replace {PATIENT_ID} with the actual patient ID you want to track

SELECT 
    'PATIENT INFO' as table_name,
    p.id as record_id,
    CONCAT(u.firstname, ' ', u.lastname) as patient_name,
    p.hospital_no,
    p.created_at,
    p.updated_at,
    'Patient record' as record_type
FROM patients p
JOIN users u ON p.user_id = u.id
WHERE p.id = {PATIENT_ID}

UNION ALL

-- Admissions
SELECT 
    'admissions' as table_name,
    id as record_id,
    CONCAT('Admission - ', reason_for_admission) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    status as record_type
FROM admissions 
WHERE patient_id = {PATIENT_ID}

UNION ALL

-- Allergies
SELECT 
    'allergies' as table_name,
    id as record_id,
    CONCAT('Allergy - ', allergy) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    'allergy' as record_type
FROM allergies 
WHERE patient_id = {PATIENT_ID}

UNION ALL

-- Antenatal Records
SELECT 
    'antenatal_records' as table_name,
    id as record_id,
    CONCAT('Antenatal - ', visit_type, ' - ', COALESCE(complaint, 'No complaint')) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    visit_type as record_type
FROM antenatal_records 
WHERE patient_id = {PATIENT_ID}

UNION ALL

-- Appointments
SELECT 
    'appointments' as table_name,
    id as record_id,
    CONCAT('Appointment - ', appointment_date) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    status as record_type
FROM appointments 
WHERE patient_id = {PATIENT_ID}

UNION ALL

-- Billings (using user_id)
SELECT 
    'billings' as table_name,
    id as record_id,
    CONCAT('Bill - ', service, ' - ₦', amount) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    CASE WHEN status = 0 THEN 'unpaid' ELSE 'paid' END as record_type
FROM billings 
WHERE user_id = {PATIENT_ID}

UNION ALL

-- Check-ins
SELECT 
    'check_ins' as table_name,
    id as record_id,
    CONCAT('Check-in - ', check_in_date) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    CASE WHEN cleared = 1 THEN 'cleared' ELSE 'pending' END as record_type
FROM check_ins 
WHERE patient_id = {PATIENT_ID}

UNION ALL

-- Deliveries
SELECT 
    'deliveries' as table_name,
    id as record_id,
    CONCAT('Delivery - ', delivery_date) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    'delivery' as record_type
FROM deliveries 
WHERE patient_id = {PATIENT_ID}

UNION ALL

-- Diagnoses
SELECT 
    'diagnoses' as table_name,
    id as record_id,
    CONCAT('Diagnosis - ', COALESCE(provisional_diagnosis, 'No diagnosis')) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    'diagnosis' as record_type
FROM diagnoses 
WHERE patient_id = {PATIENT_ID}

UNION ALL

-- Drug Requests
SELECT 
    'drug_requests' as table_name,
    id as record_id,
    CONCAT('Drug Request - ', request_date) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    status as record_type
FROM drug_requests 
WHERE patient_id = {PATIENT_ID}

UNION ALL

-- Lab Requests
SELECT 
    'lab_requests' as table_name,
    id as record_id,
    CONCAT('Lab Request - ', request_date) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    status as record_type
FROM lab_requests 
WHERE patient_id = {PATIENT_ID}

UNION ALL

-- Lab Results
SELECT 
    'lab_results' as table_name,
    id as record_id,
    CONCAT('Lab Result - ', result_date) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    'result' as record_type
FROM lab_results 
WHERE patient_id = {PATIENT_ID}

UNION ALL

-- Radiology Requests
SELECT 
    'radiology_requests' as table_name,
    id as record_id,
    CONCAT('Radiology Request - ', request_date) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    status as record_type
FROM radiology_requests 
WHERE patient_id = {PATIENT_ID}

UNION ALL

-- Radiology Results
SELECT 
    'radiology_results' as table_name,
    id as record_id,
    CONCAT('Radiology Result - ', result_date) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    'result' as record_type
FROM radiology_results 
WHERE patient_id = {PATIENT_ID}

UNION ALL

-- Procedure Requests
SELECT 
    'procedure_requests' as table_name,
    id as record_id,
    CONCAT('Procedure Request - ', request_date) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    status as record_type
FROM procedure_requests 
WHERE patient_id = {PATIENT_ID}

UNION ALL

-- Vitals
SELECT 
    'vitals' as table_name,
    id as record_id,
    CONCAT('Vitals - BP:', blood_pressure, ' Temp:', temperature) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    'vital_signs' as record_type
FROM vitals 
WHERE patient_id = {PATIENT_ID}

UNION ALL

-- Vision Acuities
SELECT 
    'vision_acuities' as table_name,
    id as record_id,
    CONCAT('Vision Test - ', test_date) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    'vision_test' as record_type
FROM vision_acuities 
WHERE patient_id = {PATIENT_ID}

UNION ALL

-- Optical Requests
SELECT 
    'optical_requests' as table_name,
    id as record_id,
    CONCAT('Optical Request - ', request_date) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    status as record_type
FROM optical_requests 
WHERE patient_id = {PATIENT_ID}

ORDER BY created_at DESC 
LIMIT 0, 25;

-- =====================================================
-- 1.1. PATIENT RECORD TRACKER WITH PAGINATION
-- =====================================================
-- Same as above but with pagination support
-- Replace {PATIENT_ID}, {OFFSET}, and {LIMIT} with actual values

SELECT 
    'PATIENT INFO' as table_name,
    p.id as record_id,
    CONCAT(u.firstname, ' ', u.lastname) as patient_name,
    p.hospital_no,
    p.created_at,
    p.updated_at,
    'Patient record' as record_type,
    'info' as category
FROM patients p
JOIN users u ON p.user_id = u.id
WHERE p.id = {PATIENT_ID}

UNION ALL

SELECT 
    'admissions' as table_name,
    id as record_id,
    CONCAT('Admission - ', reason_for_admission) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    status as record_type,
    'admission' as category
FROM admissions 
WHERE patient_id = {PATIENT_ID}

UNION ALL

SELECT 
    'allergies' as table_name,
    id as record_id,
    CONCAT('Allergy - ', allergy) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    'allergy' as record_type,
    'medical_history' as category
FROM allergies 
WHERE patient_id = {PATIENT_ID}

UNION ALL

SELECT 
    'antenatal_records' as table_name,
    id as record_id,
    CONCAT('Antenatal - ', visit_type, ' - ', COALESCE(complaint, 'No complaint')) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    visit_type as record_type,
    'antenatal' as category
FROM antenatal_records 
WHERE patient_id = {PATIENT_ID}

UNION ALL

SELECT 
    'appointments' as table_name,
    id as record_id,
    CONCAT('Appointment - ', appointment_date) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    status as record_type,
    'appointment' as category
FROM appointments 
WHERE patient_id = {PATIENT_ID}

UNION ALL

SELECT 
    'billings' as table_name,
    id as record_id,
    CONCAT('Bill - ', service, ' - ₦', FORMAT(amount, 2)) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    CASE WHEN status = 0 THEN 'unpaid' ELSE 'paid' END as record_type,
    'financial' as category
FROM billings 
WHERE user_id = {PATIENT_ID}

UNION ALL

SELECT 
    'check_ins' as table_name,
    id as record_id,
    CONCAT('Check-in - ', DATE_FORMAT(check_in_date, '%Y-%m-%d %H:%i')) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    CASE WHEN cleared = 1 THEN 'cleared' ELSE 'pending' END as record_type,
    'visit' as category
FROM check_ins 
WHERE patient_id = {PATIENT_ID}

UNION ALL

SELECT 
    'deliveries' as table_name,
    id as record_id,
    CONCAT('Delivery - ', DATE_FORMAT(delivery_date, '%Y-%m-%d')) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    'delivery' as record_type,
    'maternity' as category
FROM deliveries 
WHERE patient_id = {PATIENT_ID}

UNION ALL

SELECT 
    'diagnoses' as table_name,
    id as record_id,
    CONCAT('Diagnosis - ', COALESCE(provisional_diagnosis, 'No diagnosis')) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    'diagnosis' as record_type,
    'medical' as category
FROM diagnoses 
WHERE patient_id = {PATIENT_ID}

UNION ALL

SELECT 
    'drug_requests' as table_name,
    id as record_id,
    CONCAT('Drug Request - ', DATE_FORMAT(request_date, '%Y-%m-%d')) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    status as record_type,
    'pharmacy' as category
FROM drug_requests 
WHERE patient_id = {PATIENT_ID}

UNION ALL

SELECT 
    'lab_requests' as table_name,
    id as record_id,
    CONCAT('Lab Request - ', DATE_FORMAT(request_date, '%Y-%m-%d')) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    status as record_type,
    'laboratory' as category
FROM lab_requests 
WHERE patient_id = {PATIENT_ID}

UNION ALL

SELECT 
    'lab_results' as table_name,
    id as record_id,
    CONCAT('Lab Result - ', DATE_FORMAT(result_date, '%Y-%m-%d')) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    'result' as record_type,
    'laboratory' as category
FROM lab_results 
WHERE patient_id = {PATIENT_ID}

UNION ALL

SELECT 
    'radiology_requests' as table_name,
    id as record_id,
    CONCAT('Radiology Request - ', DATE_FORMAT(request_date, '%Y-%m-%d')) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    status as record_type,
    'radiology' as category
FROM radiology_requests 
WHERE patient_id = {PATIENT_ID}

UNION ALL

SELECT 
    'radiology_results' as table_name,
    id as record_id,
    CONCAT('Radiology Result - ', DATE_FORMAT(result_date, '%Y-%m-%d')) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    'result' as record_type,
    'radiology' as category
FROM radiology_results 
WHERE patient_id = {PATIENT_ID}

UNION ALL

SELECT 
    'procedure_requests' as table_name,
    id as record_id,
    CONCAT('Procedure Request - ', DATE_FORMAT(request_date, '%Y-%m-%d')) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    status as record_type,
    'procedure' as category
FROM procedure_requests 
WHERE patient_id = {PATIENT_ID}

UNION ALL

SELECT 
    'vitals' as table_name,
    id as record_id,
    CONCAT('Vitals - BP:', COALESCE(blood_pressure, 'N/A'), ' Temp:', COALESCE(temperature, 'N/A')) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    'vital_signs' as record_type,
    'vitals' as category
FROM vitals 
WHERE patient_id = {PATIENT_ID}

UNION ALL

SELECT 
    'vision_acuities' as table_name,
    id as record_id,
    CONCAT('Vision Test - ', DATE_FORMAT(test_date, '%Y-%m-%d')) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    'vision_test' as record_type,
    'ophthalmology' as category
FROM vision_acuities 
WHERE patient_id = {PATIENT_ID}

UNION ALL

SELECT 
    'optical_requests' as table_name,
    id as record_id,
    CONCAT('Optical Request - ', DATE_FORMAT(request_date, '%Y-%m-%d')) as description,
    NULL as hospital_no,
    created_at,
    updated_at,
    status as record_type,
    'ophthalmology' as category
FROM optical_requests 
WHERE patient_id = {PATIENT_ID}

ORDER BY created_at DESC 
LIMIT {OFFSET}, {LIMIT};

-- =====================================================
-- 2. RECORD COUNT SUMMARY BY TABLE
-- =====================================================
-- Get count of records per table for a specific patient

SELECT 
    'admissions' as table_name,
    COUNT(*) as record_count,
    MIN(created_at) as first_record,
    MAX(created_at) as last_record
FROM admissions WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'allergies', COUNT(*), MIN(created_at), MAX(created_at) FROM allergies WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'antenatal_records', COUNT(*), MIN(created_at), MAX(created_at) FROM antenatal_records WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'appointments', COUNT(*), MIN(created_at), MAX(created_at) FROM appointments WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'billings', COUNT(*), MIN(created_at), MAX(created_at) FROM billings WHERE user_id = {PATIENT_ID}
UNION ALL
SELECT 'check_ins', COUNT(*), MIN(created_at), MAX(created_at) FROM check_ins WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'deliveries', COUNT(*), MIN(created_at), MAX(created_at) FROM deliveries WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'diagnoses', COUNT(*), MIN(created_at), MAX(created_at) FROM diagnoses WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'drug_requests', COUNT(*), MIN(created_at), MAX(created_at) FROM drug_requests WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'lab_requests', COUNT(*), MIN(created_at), MAX(created_at) FROM lab_requests WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'lab_results', COUNT(*), MIN(created_at), MAX(created_at) FROM lab_results WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'radiology_requests', COUNT(*), MIN(created_at), MAX(created_at) FROM radiology_requests WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'radiology_results', COUNT(*), MIN(created_at), MAX(created_at) FROM radiology_results WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'procedure_requests', COUNT(*), MIN(created_at), MAX(created_at) FROM procedure_requests WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'vitals', COUNT(*), MIN(created_at), MAX(created_at) FROM vitals WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'vision_acuities', COUNT(*), MIN(created_at), MAX(created_at) FROM vision_acuities WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'optical_requests', COUNT(*), MIN(created_at), MAX(created_at) FROM optical_requests WHERE patient_id = {PATIENT_ID}
ORDER BY record_count DESC;

-- =====================================================
-- 3. FIND RECORDS BY DATE RANGE
-- =====================================================
-- Find all patient records created within a specific date range
-- Replace {START_DATE} and {END_DATE} with your desired date range
-- Format: 'YYYY-MM-DD HH:MM:SS'

SELECT 
    'antenatal_records' as table_name,
    id,
    patient_id,
    created_at,
    'Antenatal record' as record_type
FROM antenatal_records 
WHERE created_at BETWEEN '{START_DATE}' AND '{END_DATE}'

UNION ALL

SELECT 
    'billings' as table_name,
    id,
    user_id as patient_id,
    created_at,
    'Billing record' as record_type
FROM billings 
WHERE created_at BETWEEN '{START_DATE}' AND '{END_DATE}'

UNION ALL

SELECT 
    'lab_requests' as table_name,
    id,
    patient_id,
    created_at,
    'Lab request' as record_type
FROM lab_requests 
WHERE created_at BETWEEN '{START_DATE}' AND '{END_DATE}'

UNION ALL

SELECT 
    'diagnoses' as table_name,
    id,
    patient_id,
    created_at,
    'Diagnosis' as record_type
FROM diagnoses 
WHERE created_at BETWEEN '{START_DATE}' AND '{END_DATE}'

ORDER BY created_at DESC;

-- =====================================================
-- 4. FIND PATIENTS WITH RECENT ACTIVITY
-- =====================================================
-- Find patients who have had activity in the last N days
-- Replace {DAYS} with number of days (e.g., 7 for last week)

SELECT DISTINCT
    p.id as patient_id,
    CONCAT(u.firstname, ' ', u.lastname) as patient_name,
    p.hospital_no,
    'Recent activity' as activity_type
FROM patients p
JOIN users u ON p.user_id = u.id
WHERE p.id IN (
    SELECT DISTINCT patient_id FROM antenatal_records WHERE created_at >= DATE_SUB(NOW(), INTERVAL {DAYS} DAY)
    UNION
    SELECT DISTINCT user_id FROM billings WHERE created_at >= DATE_SUB(NOW(), INTERVAL {DAYS} DAY)
    UNION
    SELECT DISTINCT patient_id FROM lab_requests WHERE created_at >= DATE_SUB(NOW(), INTERVAL {DAYS} DAY)
    UNION
    SELECT DISTINCT patient_id FROM diagnoses WHERE created_at >= DATE_SUB(NOW(), INTERVAL {DAYS} DAY)
    UNION
    SELECT DISTINCT patient_id FROM vitals WHERE created_at >= DATE_SUB(NOW(), INTERVAL {DAYS} DAY)
);

-- =====================================================
-- 5. COMPARE OFFLINE VS ONLINE RECORDS
-- =====================================================
-- Use this to compare record counts between offline and online databases
-- Run this on both databases and compare results

SELECT 
    'SUMMARY' as info,
    COUNT(DISTINCT p.id) as total_patients,
    (SELECT COUNT(*) FROM antenatal_records) as antenatal_records,
    (SELECT COUNT(*) FROM billings) as billings,
    (SELECT COUNT(*) FROM lab_requests) as lab_requests,
    (SELECT COUNT(*) FROM diagnoses) as diagnoses,
    (SELECT COUNT(*) FROM vitals) as vitals,
    NOW() as query_time
FROM patients p;

-- =====================================================
-- 6. FIND MISSING RECORDS
-- =====================================================
-- Find patients who exist in one table but not in another
-- This helps identify incomplete synchronization

-- Patients with antenatal records but no billings
SELECT 
    p.id,
    CONCAT(u.firstname, ' ', u.lastname) as patient_name,
    p.hospital_no,
    'Has antenatal but no billing' as issue
FROM patients p
JOIN users u ON p.user_id = u.id
WHERE p.id IN (SELECT DISTINCT patient_id FROM antenatal_records)
AND p.id NOT IN (SELECT DISTINCT user_id FROM billings WHERE user_id IS NOT NULL);

-- Patients with billings but no antenatal records
SELECT 
    p.id,
    CONCAT(u.firstname, ' ', u.lastname) as patient_name,
    p.hospital_no,
    'Has billing but no antenatal' as issue
FROM patients p
JOIN users u ON p.user_id = u.id
WHERE p.id IN (SELECT DISTINCT user_id FROM billings WHERE user_id IS NOT NULL)
AND p.id NOT IN (SELECT DISTINCT patient_id FROM antenatal_records);

-- =====================================================
-- 7. PATIENT ACTIVITY TIMELINE
-- =====================================================
-- Get a chronological timeline of all activities for a patient
-- This is useful for understanding the patient journey

SELECT 
    DATE(created_at) as activity_date,
    COUNT(*) as activities_count,
    GROUP_CONCAT(DISTINCT table_name ORDER BY created_at) as activity_types
FROM (
    SELECT 'antenatal_records' as table_name, created_at FROM antenatal_records WHERE patient_id = {PATIENT_ID}
    UNION ALL
    SELECT 'billings' as table_name, created_at FROM billings WHERE user_id = {PATIENT_ID}
    UNION ALL
    SELECT 'lab_requests' as table_name, created_at FROM lab_requests WHERE patient_id = {PATIENT_ID}
    UNION ALL
    SELECT 'diagnoses' as table_name, created_at FROM diagnoses WHERE patient_id = {PATIENT_ID}
    UNION ALL
    SELECT 'vitals' as table_name, created_at FROM vitals WHERE patient_id = {PATIENT_ID}
    UNION ALL
    SELECT 'appointments' as table_name, created_at FROM appointments WHERE patient_id = {PATIENT_ID}
) as all_activities
GROUP BY DATE(created_at)
ORDER BY activity_date DESC;

-- =====================================================
-- 8. SYNC STATUS CHECKER
-- =====================================================
-- Check for records that might need synchronization
-- Look for records created/updated in the last 24 hours

SELECT 
    table_name,
    record_count,
    last_updated,
    CASE 
        WHEN last_updated > DATE_SUB(NOW(), INTERVAL 1 DAY) THEN 'Recent Activity'
        WHEN last_updated > DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 'Weekly Activity'
        ELSE 'Older Records'
    END as sync_priority
FROM (
    SELECT 'antenatal_records' as table_name, COUNT(*) as record_count, MAX(updated_at) as last_updated 
    FROM antenatal_records WHERE patient_id = {PATIENT_ID}
    UNION ALL
    SELECT 'billings', COUNT(*), MAX(updated_at) FROM billings WHERE user_id = {PATIENT_ID}
    UNION ALL
    SELECT 'lab_requests', COUNT(*), MAX(updated_at) FROM lab_requests WHERE patient_id = {PATIENT_ID}
    UNION ALL
    SELECT 'diagnoses', COUNT(*), MAX(updated_at) FROM diagnoses WHERE patient_id = {PATIENT_ID}
    UNION ALL
    SELECT 'vitals', COUNT(*), MAX(updated_at) FROM vitals WHERE patient_id = {PATIENT_ID}
) as sync_status
WHERE record_count > 0
ORDER BY last_updated DESC;

-- =====================================================
-- 9. FINANCIAL SUMMARY FOR PATIENT
-- =====================================================
-- Get financial overview for a specific patient

SELECT 
    COUNT(*) as total_bills,
    SUM(amount) as total_amount,
    SUM(CASE WHEN status = 1 THEN amount ELSE 0 END) as paid_amount,
    SUM(CASE WHEN status = 0 THEN amount ELSE 0 END) as outstanding_amount,
    AVG(amount) as average_bill,
    MIN(created_at) as first_bill_date,
    MAX(created_at) as last_bill_date
FROM billings 
WHERE user_id = {PATIENT_ID};

-- =====================================================
-- 10. MEDICAL HISTORY SUMMARY
-- =====================================================
-- Get a summary of medical activities for a patient

SELECT 
    'Diagnoses' as category,
    COUNT(*) as count,
    MIN(created_at) as first_record,
    MAX(created_at) as last_record
FROM diagnoses WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'Lab Tests', COUNT(*), MIN(created_at), MAX(created_at) FROM lab_requests WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'Radiology', COUNT(*), MIN(created_at), MAX(created_at) FROM radiology_requests WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'Procedures', COUNT(*), MIN(created_at), MAX(created_at) FROM procedure_requests WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'Vitals', COUNT(*), MIN(created_at), MAX(created_at) FROM vitals WHERE patient_id = {PATIENT_ID}
UNION ALL
SELECT 'Antenatal Visits', COUNT(*), MIN(created_at), MAX(created_at) FROM antenatal_records WHERE patient_id = {PATIENT_ID}
ORDER BY count DESC;