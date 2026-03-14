<?php

use App\Http\Controllers\BillingServiceController;
use App\Http\Controllers\PatientBillController;
use App\Models\Consumble;
use App\Models\Appointment;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BedController;
use App\Http\Controllers\IOPController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\ICD10Controller;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VitalsController;
use App\Http\Controllers\AllergyController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\HmoPlanController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OpticalController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HmoGroupController;
use App\Http\Controllers\HmoServiceController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\VitalRefController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\AntenatalController;
use App\Http\Controllers\AntenatalRecordController;
use App\Http\Controllers\CashPointController;
use App\Http\Controllers\ConsumbleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\DrugStoreController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\RadiologyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\LabRequestController;
use App\Http\Controllers\RefractionController;
use App\Http\Controllers\SpecialityController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\LabTemplateController;
use App\Http\Controllers\WaitingListController;
use App\Http\Controllers\StoreRequestController;
use App\Http\Controllers\VisionAcuityController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ConsultingRoomController;
use App\Http\Controllers\SystemSettingsController;
use App\Http\Controllers\AppointmentTypeController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ProcedureRequestController;
use App\Http\Controllers\RadiologyRequestController;
use App\Http\Controllers\ConsultingTemplateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return redirect()->route('app.dashboard');
});

Auth::routes();


Route::group(['prefix' => 'app', 'as' => 'app.', 'middleware' => ['auth', 'access.expiration']], function () {
  Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::resource('allergies', AllergyController::class);
  Route::resource('users', UserController::class);
  Route::resource('diagnosis', DiagnosisController::class);
  Route::get('diagnosis/{id}', [DiagnosisController::class, 'show'])->name('show.diagnosis');
  Route::get('diagnosis/{id}/print', [DiagnosisController::class, 'print'])->name('print.diagnosis');
  Route::resource('roles', RoleController::class);
  Route::resource('patients', PatientController::class);
  Route::get('patient-tag/{patient}', [PatientController::class, 'tag'])->name('patients.tag');
  Route::post('patient/tag', [PatientController::class, 'addTag'])->name('patients.tag.post');
  Route::get('patient/draw/{id}', [PatientController::class, 'draw'])->name('patient.draw');
  Route::get('patient/check-in/{id}', [PatientController::class, 'checkIn'])->name('patient.checkIn');
  Route::post('patient/check-in/{id}/approve', [PatientController::class, 'approveCheckIn'])->name('patient.checkIn.approve');
  Route::get('patient/fund-wallet/{id}', [PatientController::class, 'fundWalletView'])->name('patient.fund.wallet');
  Route::post('patient/fund-wallet', [PatientController::class, 'fundWalletSave'])->name('patient.fund.wallet.save');
  Route::get('patient/schedule-appointment/{id}', [PatientController::class, 'scheduleAppointment'])->name('patient.schedule.appointment');
  Route::resource('hmos', HmoGroupController::class);
  Route::resource('opticals', OpticalController::class);
  Route::resource('departments', DepartmentController::class);
  Route::resource('documents', DocumentController::class);
  Route::resource('payment-methods', PaymentMethodController::class);
  Route::resource('religions', ReligionController::class);
  Route::get('hmo-plans/{plan}/services', [HmoServiceController::class, 'index'])->name('hmo-plans.services.index');
  Route::get('hmo-plans/{plan}/services/export', [HmoServiceController::class, 'export'])->name('hmo-plans.services.export');
  Route::get('hmo-plans/{plan}/services/import', [HmoServiceController::class, 'importView'])->name('hmo-plans.services.import');
  Route::post('hmo-plans/{plan}/services/import', [HmoServiceController::class, 'import'])->name('hmo-plans.services.import.post');
  Route::get('hmo-plans/{plan}/services/create', [HmoServiceController::class, 'create'])->name('hmo-plans.services.create');
  Route::get('hmo-plans-services-template', [HmoServiceController::class, 'downloadTemplate'])->name('hmo-plans.services.template');
  Route::post('hmo-plans/{plan}/services', [HmoServiceController::class, 'store'])->name('hmo-plans.services.store');
  Route::put('hmo-services/{hmo_service}', [HmoServiceController::class, 'update'])->name('hmo-services.update');
  Route::delete('hmo-services/{hmo_service}', [HmoServiceController::class, 'destroy'])->name('hmo-services.destroy');
  Route::resource('hmo-plans', HmoPlanController::class);
  Route::get('hmo-plans-import', [HmoPlanController::class, 'importView'])->name('hmo-plans.import');
  Route::post('hmo-plans-import', [HmoPlanController::class, 'import'])->name('hmo-plans.import.post');
  Route::resource('wards', WardController::class);
  Route::resource('beds', BedController::class);
  Route::get('bed-export', [BedController::class, 'export'])->name('bed.export');
  Route::get('bed-import', [BedController::class, 'importView'])->name('bed.import');
  Route::post('bed-import', [BedController::class, 'import'])->name('beds.import');
  Route::resource('messages', MessageController::class);
  Route::resource('appointments', AppointmentController::class);
  Route::get('appointment/schedule/{patient}', [AppointmentController::class, 'schedule'])->name('appointment.schedule');
  Route::resource('pharmacy', PharmacyController::class);
  Route::get('settings/pharmacy', [SystemSettingsController::class, 'PharmacySettings'])->name('settings.pharmacy');
  Route::get('settings/pharmacy/edit/{id}', [PharmacyController::class, 'editDrug'])->name('settings.pharmacy.edit');
  Route::put('settings/pharmacy/update/{id}', [PharmacyController::class, 'updateDrug'])->name('settings.pharmacy.update');
  Route::get('settings/pharmacy/drug-category/edit/{id}', [DrugController::class, 'editCategory'])->name('drugs-category.edit');
  Route::get('settings/pharmacy/drug-store/edit/{id}', [DrugStoreController::class, 'edit'])->name('drugs-store.edit');

  Route::get('pharmacy/request/{id}', [PharmacyController::class, 'print'])->name('pharmacy.request.print');
  Route::post('lab-category', [LaboratoryController::class, 'storeCategory'])->name('lab-category.store');
  Route::get('lab-category/{category}', [LaboratoryController::class, 'editCategory'])->name('lab-category.edit');
  Route::put('lab-category/{category}', [LaboratoryController::class, 'UpdateCategory'])->name('lab-category.update');
  Route::delete('lab-category/{category}', [LaboratoryController::class, 'deleteCategory'])->name('lab-category.destroy');
  Route::get('lab-export', [LaboratoryController::class, 'Export'])->name('lab.export');
  Route::post('lab-import', [LaboratoryController::class, 'Import'])->name('lab.import');
  Route::post('lab-category/{category}', [LaboratoryController::class, 'updateCategory'])->name('lab-category.update');
  Route::post('lab-parameter', [LabTemplateController::class, 'storeLabParameter'])->name('lab-parameter.store');
  Route::get('lab-parameter/{id}', [LabTemplateController::class, 'editLabParameter'])->name('lab-parameter.edit');
  Route::put('lab-parameter/{id}', [LabTemplateController::class, 'updateLabParameter'])->name('lab-parameter.update');
  Route::delete('lab-parameter/{id}', [LabTemplateController::class, 'deleteLabParameter'])->name('lab-parameter.destroy');
  Route::delete('lab-template/{template}', [LaboratoryController::class, 'deleteTemplate'])->name('lab-template.destroy');
  Route::get('lab-template/{template}', [LaboratoryController::class, 'editTemplate'])->name('lab-template.edit');
  Route::put('lab-template/{template}', [LaboratoryController::class, 'updateTemplate'])->name('lab-template.update');
  Route::post('lab-test', [LaboratoryController::class, 'store'])->name('lab-test.store');
  Route::get('lab-test/{id}', [LaboratoryController::class, 'edit'])->name('lab-test.edit');
  Route::delete('lab-test/{id}', [LaboratoryController::class, 'destroy'])->name('lab-test.destroy');
  Route::put('lab-test/{test}', [LaboratoryController::class, 'update'])->name('lab-test.update');
  Route::delete('drugs-delete/{id}', [DrugController::class, 'destroy'])->name('settings.drugs.destroy');
  Route::post('drugs-add', [DrugController::class, 'storeDrugs'])->name('drugs-add.store');
  Route::post('drugs-add/{drugs}', [DrugController::class, 'updateDrugs'])->name('drugs-add.update');
  Route::post('drugs-store', [DrugStoreController::class, 'store'])->name('drugs-store.store');

  Route::post('drugs-category', [DrugController::class, 'storeCategory'])->name('drugs-category.store');
  Route::post('drugs-category/{category}', [DrugController::class, 'updateCategory'])->name('drugs-category.update');
  Route::resource('lab', LabRequestController::class);
  Route::resource('store-request', StoreRequestController::class);
  Route::get('lab/specimen/{lab}', [LabRequestController::class, 'specimen'])->name('lab.specimen');
  Route::post('lab/add-result', [LabRequestController::class, 'addResult'])->name('lab.add.result');
  Route::get('lab/result/{lab}', [LabRequestController::class, 'showResult'])->name('lab.print.result');
  Route::resource('vitals', VitalsController::class);
  Route::resource('vision-acuity', VisionAcuityController::class);
  Route::resource('iop', IOPController::class);
  Route::get('vision-acuity/{id}', [VisionAcuityController::class, 'show'])->name('show.va');
  Route::get('vision-acuity-create/{patient}/', [VisionAcuityController::class, 'create'])->name('create.va');
  Route::get('vision-acuity/{patient}/{va}', [VisionAcuityController::class, 'edit'])->name('edit.va');
  Route::delete('vision-acuity/{id}', [VisionAcuityController::class, 'destroy'])->name('delete.va');
  Route::get('iop/{id}', [IOPController::class, 'show'])->name('show.iop');
  Route::get('iop/{patient}/{iop}', [IOPController::class, 'edit'])->name('edit.iop');
  Route::delete('iop/{id}', [IOPController::class, 'destroy'])->name('delete.iop');
  Route::post('lab-category', [LaboratoryController::class, 'storeCategory'])->name('lab-category.store');

  Route::post('consumables-add', [ConsumbleController::class, 'storeConsumables'])->name('consumables-add.store');
  Route::get('consumables-add/edit/{id}', [ConsumbleController::class, 'editConsumables'])->name('consumables-add.edit');
  Route::put('consumables-add/{id}', [ConsumbleController::class, 'updateConsumables'])->name('consumables-add.update');
  Route::post('consumables-category', [ConsumbleController::class, 'storeCategory'])->name('consumables-category.store');
  Route::get('consumables-category/edit/{id}', [ConsumbleController::class, 'editCategory'])->name('consumables-category.edit');
  Route::put('consumables-category/{id}', [ConsumbleController::class, 'updateCategory'])->name('consumables-category.update');


  Route::resource('procedures', ProcedureController::class);
  Route::post('procedure', [ProcedureController::class, 'storeProcedure'])->name('procedure.store');
  Route::get('procedure/editCategory/{id}', [ProcedureController::class, 'editCategory'])->name('procedures.category.edit');
  Route::put('procedure/{procedures}', [ProcedureController::class, 'updateProcedure'])->name('procedure.update');
  Route::delete('procedure/category-delete/{id}', [ProcedureController::class, 'deleteCategory'])->name('procedure.delete.category');
  Route::put('procedure/category/{id}', [ProcedureController::class, 'UpdateCategory'])->name('procedure.update.category');
  Route::post('procedures-category', [ProcedureController::class, 'storeCategory'])->name('procedures-category.store');
  Route::post('procedures-category/{category}', [ProcedureController::class, 'updateCategory'])->name('procedures-category.update');

  Route::resource('procedure-requests', ProcedureRequestController::class);
  Route::get('procedure-prepare/{id}', [ProcedureRequestController::class, 'prepare'])->name('procedure.prepare');

  Route::get('/getBedsByWard/{wardId}', [WardController::class, 'getBedsByWard'])->name('getBedsByWard');


  // **** Radiology Routes
  Route::resource('radiology', RadiologyRequestController::class);
  Route::get('radiology-add-notes', [RadiologyRequestController::class, 'addFindings'])->name('radiology.requests.notes.add');
  Route::post('radiology-add-result', [RadiologyRequestController::class, 'addResult'])->name('radiology.add.result');
  Route::get('radiology-edit-result/{id}', [RadiologyRequestController::class, 'editResult'])->name('radiology.edit.result');
  Route::post('radiology-update-result', [RadiologyRequestController::class, 'updateResult'])->name('radiology.update.result');
  Route::get('radiology/result/{lab}', [RadiologyRequestController::class, 'showResult'])->name('radiology.print.result');
  Route::post('radiology-category', [RadiologyController::class, 'storeCategory'])->name('radiology-category.store');
  Route::get('radiology-category/edit/{id}', [RadiologyController::class, 'editCategory'])->name('radiology-category.edit');
  Route::put('radiology-category/{id}', [RadiologyController::class, 'updateCategory'])->name('radiology-category.update');
  Route::post('radiology-template', [RadiologyController::class, 'storeTemplate'])->name('radiology-template.store');
  Route::post('radiology-test', [RadiologyController::class, 'store'])->name('radiology-test.store');
  Route::post('radiology-test/{test}', [RadiologyController::class, 'update'])->name('radiology-test.update');
  Route::get('radiology-test/{test}', [RadiologyController::class, 'edit'])->name('radiology-test.edit');

  //

  Route::resource('wait-list', WaitingListController::class);
  Route::resource('consumables', ConsumbleController::class);
  Route::resource('icd', ICD10Controller::class);
  Route::post('/import-icd10', [ICD10Controller::class, 'import'])->name('import-icd10');
  Route::get('add-icd10', [ICD10Controller::class, 'single'])->name('create.single');
  Route::resource('tags', TagController::class);
  Route::resource('admissions', AdmissionController::class);
  Route::get('admissions/request/{id}', [AdmissionController::class, 'requestAdmission'])->name('admissions.request');
  Route::post('admissions/request', [AdmissionController::class, 'storeAdmissionRequest'])->name('admissions.store-request');
  Route::get('admission/bill/{admission}', [AdmissionController::class, 'bill'])->name('admissions.bill');
  Route::post('admission/bill', [AdmissionController::class, 'billAdmission'])->name('admissions.bill.post');
  Route::get('admission-bed/{ref}', [AdmissionController::class, 'assignBed'])->name('admissions.bed');
  Route::resource('billing', BillingController::class);
  Route::resource('antenatals', AntenatalController::class);
  Route::get('antenatal-export', [AntenatalController::class, 'export'])->name('antenatal.export');
  Route::get('antenatal-import', [AntenatalController::class, 'importView'])->name('antenatal.import');
  Route::post('antenatal-import', [AntenatalController::class, 'import'])->name('antenatal.import.post');
  // Antenatal Records (per-patient visit records)
  Route::post('antenatal-records', [AntenatalRecordController::class, 'store'])->name('antenatal-records.store');
  Route::get('antenatal-records/{antenatalRecord}', [AntenatalRecordController::class, 'show'])->name('antenatal-records.show');
  Route::delete('antenatal-records/{antenatalRecord}', [AntenatalRecordController::class, 'destroy'])->name('antenatal-records.destroy');
  Route::resource('specialities', SpecialityController::class);
  Route::resource('reports', ReportController::class);
  Route::get('report/general', [ReportController::class, 'generalReport'])->name('reports.general');
  Route::get('report/pharmacy', [ReportController::class, 'pharmacyReport'])->name('reports.pharmacy');
  Route::get('report/lab', [ReportController::class, 'labReport'])->name('reports.lab');
  Route::get('report/radiology', [ReportController::class, 'radiologyReport'])->name('reports.radiology');
  Route::get('report/procedures', [ReportController::class, 'procedureReport'])->name('reports.procedure');
  Route::get('report/billings', [ReportController::class, 'billingReport'])->name('reports.billing');
  Route::get('report/hmo', App\Livewire\HmoReport::class)->name('reports.hmo');
  Route::get('report/hmo-reconciliation', App\Livewire\HmoReconciliation::class)->name('reports.hmo-reconciliation');
  Route::get('hmo/finance', App\Livewire\HmoFinance::class)->name('hmo.finance');
  Route::get('hmo/billing', App\Livewire\HmoBillingList::class)->name('hmo.billing');
  Route::resource('consulting-rooms', ConsultingRoomController::class);
  Route::resource('appointment-type', AppointmentTypeController::class);
  Route::resource('consulting-templates', ConsultingTemplateController::class);
  Route::resource('settings', SystemSettingsController::class)->except('store', 'update', 'edit', 'show', 'destroy');
  Route::post('settings', [SystemSettingsController::class, 'updateSystemSettings'])->name('update.system.settings');
  Route::post('settings/currency', [SystemSettingsController::class, 'updateStoreCurrency'])->name('update.store.currency');
  Route::get('settings/admission', [SystemSettingsController::class, 'admissionSettings'])->name('settings.admission');
  Route::get('settings/ophthical', [SystemSettingsController::class, 'ophthicalSettings'])->name('settings.ophthical');
  Route::get('settings/consultations', [SystemSettingsController::class, 'consultationSettings'])->name('settings.consultations');
  Route::get('settings/consumables', [SystemSettingsController::class, 'consumablesSettings'])->name('settings.consumables');
  Route::get('settings/pharmacy', [SystemSettingsController::class, 'PharmacySettings'])->name('settings.pharmacy');
  Route::get('settings/laboratory', [SystemSettingsController::class, 'LaboratorySettings'])->name('settings.laboratory');
  Route::get('settings/radiology', [SystemSettingsController::class, 'RadiologySettings'])->name('settings.radiology');
  Route::get('settings/procedures', [SystemSettingsController::class, 'ProcedureSettings'])->name('settings.procedures');
  Route::get('settings/dialysis', [SystemSettingsController::class, 'RadiologySettings'])->name('settings.dialysis');
  Route::resource('categories', ServiceCategoryController::class);
  Route::resource('positions', PositionController::class);
  Route::resource('allergies', AllergyController::class);
  Route::resource('vitalRefs', VitalRefController::class);
  Route::resource('cashpoints', CashPointController::class);
  Route::get('cashpoints/new-patient/{patient}', [CashPointController::class, 'newPatient'])->name('cashpoints.new-patient');
  Route::post('cashpoint/bill-patient', [CashPointController::class, 'billPatient'])->name('cashpoints.bill-patient');
  Route::resource('payments', PaymentController::class);
  Route::post('payments/new-enroll', [PaymentController::class, 'storeEnroll'])->name('payments.new-enroll');
  Route::post('payments/new-enroll', [PaymentController::class, 'storeEnroll'])->name('payments.new-enroll');
  Route::get('payment/new-method', [PaymentController::class, 'newMethod'])->name('payments.new-method');
  Route::post('payment/new-method', [PaymentController::class, 'saveMethod'])->name('payments.save-method');
  Route::get('payment/edit-method/{id}', [PaymentController::class, 'EditMethod'])->name('payments.edit-method');
  Route::post('payment/update-method', [PaymentController::class, 'UpdateMethod'])->name('payments.update-method');
  Route::post('payment/delete-method', [PaymentController::class, 'DeleteMethod'])->name('payments.delete-method');
  Route::get('payment/print', function () {
    return view('billing.print');
  })->name('payment.print');
  Route::get('refraction/create/{patient}', [RefractionController::class, 'create'])->name('refraction.create');
  Route::resource('refraction', RefractionController::class)->only(['index', 'store', 'show', 'edit', 'update', 'destroy']);
  Route::get('refraction/print/{refraction}', [RefractionController::class, 'print'])->name('refraction.print');

  Route::get('bills', function () {
    return view('billing.bill-modal');
  })->name('new.bill');

  Route::get('patients-first-timer', function () {
    return view('patients.first-timer');
  })->name('patients.first-timer');
  Route::post('lab-template/store', [LabTemplateController::class, 'store'])
    ->name('lab-template.store');
});
Route::get('getLGA/{state}', [DashboardController::class, 'getLGA']);
Route::post('getDrugsCategorybyStore', [DrugController::class, 'getDrugsCategorybyStore']);
Route::post('getDrugsbyStore', [DrugController::class, 'getDrugsbyStore'])->name('get.drugs.by.store');
Route::post('/getDrugsByCategory', [\App\Http\Controllers\DrugController::class, 'getByCategory']);



Route::get('getPatients', [PatientBillController::class, 'index'])->name('patients.search');
Route::post('patient-first-timer', [PatientBillController::class, 'store'])->name('patients.first-timer');
Route::post('/billservice', [BillingServiceController::class, 'index'])->name('bill.services');
Route::get('/billservices/{patient}/{type}/{accessCode}', [BillingServiceController::class, 'verifyAccessCode'])->name('bill.services.verify');

// URL::forceScheme('https');
