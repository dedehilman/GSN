<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return redirect('/home');
});

Auth::routes();

Route::get('/locale/{locale}', [App\Http\Controllers\LocaleController::class, 'index'])->name('locale');
Route::get('/notification/{id}', [App\Http\Controllers\NotificationController::class, 'index'])->name('notification');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// System
Route::get('/system/change-password', [App\Http\Controllers\ChangePasswordController::class, 'index'])->name('change-password');
Route::post('/system/change-password', [App\Http\Controllers\ChangePasswordController::class, 'store'])->name('change-password.store');
Route::get('/system/appearance-setting', [App\Http\Controllers\AppearanceSettingController::class, 'index'])->name('appearance-setting');
Route::post('/system/appearance-setting', [App\Http\Controllers\AppearanceSettingController::class, 'store'])->name('appearance-setting.store');
Route::post('/system/permission/datatable', [App\Http\Controllers\System\PermissionController::class, 'datatable'])->name('permission.datatable');
Route::post('/system/permission/datatable/select', [App\Http\Controllers\System\PermissionController::class, 'datatableSelect'])->name('permission.datatable.select');
Route::get('/system/permission/select', [App\Http\Controllers\System\PermissionController::class, 'select'])->name('permission.select');
Route::resource('system/permission', App\Http\Controllers\System\PermissionController::class);
Route::post('/system/menu/datatable', [App\Http\Controllers\System\MenuController::class, 'datatable'])->name('menu.datatable');
Route::post('/system/menu/datatable/select', [App\Http\Controllers\System\MenuController::class, 'datatableSelect'])->name('menu.datatable.select');
Route::get('/system/menu/select', [App\Http\Controllers\System\MenuController::class, 'select'])->name('menu.select');
Route::resource('system/menu', App\Http\Controllers\System\MenuController::class);
Route::post('/system/record-rule/datatable', [App\Http\Controllers\System\RecordRuleController::class, 'datatable'])->name('record-rule.datatable');
Route::post('/system/record-rule/datatable/select', [App\Http\Controllers\System\RecordRuleController::class, 'datatableSelect'])->name('record-rule.datatable.select');
Route::get('/system/record-rule/select', [App\Http\Controllers\System\RecordRuleController::class, 'select'])->name('record-rule.select');
Route::resource('system/record-rule', App\Http\Controllers\System\RecordRuleController::class);
Route::post('/system/parameter/datatable', [App\Http\Controllers\System\ParameterController::class, 'datatable'])->name('parameter.datatable');
Route::resource('system/parameter', App\Http\Controllers\System\ParameterController::class);
Route::post('/system/role/datatable', [App\Http\Controllers\System\RoleController::class, 'datatable'])->name('role.datatable');
Route::resource('system/role', App\Http\Controllers\System\RoleController::class);
Route::post('/system/user/datatable', [App\Http\Controllers\System\UserController::class, 'datatable'])->name('user.datatable');
Route::post('/system/user/datatable/select', [App\Http\Controllers\System\UserController::class, 'datatableSelect'])->name('user.datatable.select');
Route::get('/system/user/select', [App\Http\Controllers\System\UserController::class, 'select'])->name('user.select');
Route::resource('system/user', App\Http\Controllers\System\UserController::class);
Route::post('/system/sequence/datatable', [App\Http\Controllers\System\SequenceController::class, 'datatable'])->name('sequence.datatable');
Route::post('/system/sequence/datatable/select', [App\Http\Controllers\System\SequenceController::class, 'datatableSelect'])->name('sequence.datatable.select');
Route::get('/system/sequence/select', [App\Http\Controllers\System\SequenceController::class, 'select'])->name('sequence.select');
Route::resource('system/sequence', App\Http\Controllers\System\SequenceController::class);
Route::resource('system/sequence/{parentId}/period', App\Http\Controllers\System\SequencePeriodController::class, ['as' => 'sequence']);
Route::post('/system/sequence/{parentId}/period/datatable', [App\Http\Controllers\System\SequencePeriodController::class, 'datatable'])->name('sequence.period.datatable');
Route::post('/system/route/datatable', [App\Http\Controllers\System\RouteController::class, 'datatable'])->name('route.datatable');
Route::resource('system/route', App\Http\Controllers\System\RouteController::class);
Route::post('/system/rule/datatable', [App\Http\Controllers\System\RuleController::class, 'datatable'])->name('rule.datatable');
Route::post('/system/rule/datatable/select', [App\Http\Controllers\System\RuleController::class, 'datatableSelect'])->name('rule.datatable.select');
Route::get('/system/rule/select', [App\Http\Controllers\System\RuleController::class, 'select'])->name('rule.select');
Route::resource('system/rule', App\Http\Controllers\System\RuleController::class);
Route::post('/system/job/datatable', [App\Http\Controllers\System\JobController::class, 'datatable'])->name('job.datatable');
Route::resource('system/job', App\Http\Controllers\System\JobController::class);
Route::post('/system/notification-template/datatable', [App\Http\Controllers\System\NotificationTemplateController::class, 'datatable'])->name('notification-template.datatable');
Route::post('/system/notification-template/datatable/select', [App\Http\Controllers\System\NotificationTemplateController::class, 'datatableSelect'])->name('notification-template.datatable.select');
Route::get('/system/notification-template/select', [App\Http\Controllers\System\NotificationTemplateController::class, 'select'])->name('notification-template.select');
Route::resource('system/notification-template', App\Http\Controllers\System\NotificationTemplateController::class);
Route::get('/system/route/{parentId}/node', [App\Http\Controllers\System\NodeController::class, 'index'])->name('route.node.index');
Route::post('/system/route/{parentId}/node/store', [App\Http\Controllers\System\NodeController::class, 'store'])->name('route.node.store');
Route::resource('system/route/{parentId}/notification', App\Http\Controllers\System\RouteNotificationController::class, ['as' => 'route']);
Route::post('/system/route/{parentId}/notification/datatable', [App\Http\Controllers\System\RouteNotificationController::class, 'datatable'])->name('route.notification.datatable');
Route::post('/system/mail-history/datatable', [App\Http\Controllers\System\MailHistoryController::class, 'datatable'])->name('mail-history.datatable');
Route::resource('system/mail-history', App\Http\Controllers\System\MailHistoryController::class);

// Master
Route::post('/master/company-group/datatable', [App\Http\Controllers\Master\CompanyGroupController::class, 'datatable'])->name('company-group.datatable');
Route::post('/master/company-group/datatable/select', [App\Http\Controllers\Master\CompanyGroupController::class, 'datatableSelect'])->name('company-group.datatable.select');
Route::get('/master/company-group/select', [App\Http\Controllers\Master\CompanyGroupController::class, 'select'])->name('company-group.select');
Route::resource('master/company-group', App\Http\Controllers\Master\CompanyGroupController::class);
Route::post('/master/company/datatable', [App\Http\Controllers\Master\CompanyController::class, 'datatable'])->name('company.datatable');
Route::post('/master/company/datatable/select', [App\Http\Controllers\Master\CompanyController::class, 'datatableSelect'])->name('company.datatable.select');
Route::get('/master/company/select', [App\Http\Controllers\Master\CompanyController::class, 'select'])->name('company.select');
Route::resource('master/company', App\Http\Controllers\Master\CompanyController::class);
Route::post('/master/position/datatable', [App\Http\Controllers\Master\PositionController::class, 'datatable'])->name('position.datatable');
Route::post('/master/position/datatable/select', [App\Http\Controllers\Master\PositionController::class, 'datatableSelect'])->name('position.datatable.select');
Route::get('/master/position/select', [App\Http\Controllers\Master\PositionController::class, 'select'])->name('position.select');
Route::resource('master/position', App\Http\Controllers\Master\PositionController::class);
Route::post('/master/department/datatable', [App\Http\Controllers\Master\DepartmentController::class, 'datatable'])->name('department.datatable');
Route::post('/master/department/datatable/select', [App\Http\Controllers\Master\DepartmentController::class, 'datatableSelect'])->name('department.datatable.select');
Route::get('/master/department/select', [App\Http\Controllers\Master\DepartmentController::class, 'select'])->name('department.select');
Route::get('/master/department/treeview', [App\Http\Controllers\Master\DepartmentController::class, 'getTreeview'])->name('department.treeview');
Route::resource('master/department', App\Http\Controllers\Master\DepartmentController::class);
Route::post('/master/attribute/datatable', [App\Http\Controllers\Master\AttributeController::class, 'datatable'])->name('attribute.datatable');
Route::post('/master/attribute/datatable/select', [App\Http\Controllers\Master\AttributeController::class, 'datatableSelect'])->name('attribute.datatable.select');
Route::get('/master/attribute/select', [App\Http\Controllers\Master\AttributeController::class, 'select'])->name('attribute.select');
Route::resource('master/attribute', App\Http\Controllers\Master\AttributeController::class);
Route::post('/master/employee/datatable', [App\Http\Controllers\Master\EmployeeController::class, 'datatable'])->name('employee.datatable');
Route::post('/master/employee/datatable/select', [App\Http\Controllers\Master\EmployeeController::class, 'datatableSelect'])->name('employee.datatable.select');
Route::get('/master/employee/select', [App\Http\Controllers\Master\EmployeeController::class, 'select'])->name('employee.select');
Route::resource('master/employee', App\Http\Controllers\Master\EmployeeController::class);
Route::post('/master/relationship/datatable', [App\Http\Controllers\Master\RelationshipController::class, 'datatable'])->name('relationship.datatable');
Route::post('/master/relationship/datatable/select', [App\Http\Controllers\Master\RelationshipController::class, 'datatableSelect'])->name('relationship.datatable.select');
Route::get('/master/relationship/select', [App\Http\Controllers\Master\RelationshipController::class, 'select'])->name('relationship.select');
Route::resource('master/relationship', App\Http\Controllers\Master\RelationshipController::class);

Route::post('/master/unit/datatable', [App\Http\Controllers\Master\UnitController::class, 'datatable'])->name('unit.datatable');
Route::post('/master/unit/datatable/select', [App\Http\Controllers\Master\UnitController::class, 'datatableSelect'])->name('unit.datatable.select');
Route::get('/master/unit/select', [App\Http\Controllers\Master\UnitController::class, 'select'])->name('unit.select');
Route::resource('master/unit', App\Http\Controllers\Master\UnitController::class);

Route::post('/master/medicine-rule/datatable', [App\Http\Controllers\Master\MedicineRuleController::class, 'datatable'])->name('medicine-rule.datatable');
Route::post('/master/medicine-rule/datatable/select', [App\Http\Controllers\Master\MedicineRuleController::class, 'datatableSelect'])->name('medicine-rule.datatable.select');
Route::get('/master/medicine-rule/select', [App\Http\Controllers\Master\MedicineRuleController::class, 'select'])->name('medicine-rule.select');
Route::resource('master/medicine-rule', App\Http\Controllers\Master\MedicineRuleController::class);

Route::post('/master/medicine-type/datatable', [App\Http\Controllers\Master\MedicineTypeController::class, 'datatable'])->name('medicine-type.datatable');
Route::post('/master/medicine-type/datatable/select', [App\Http\Controllers\Master\MedicineTypeController::class, 'datatableSelect'])->name('medicine-type.datatable.select');
Route::get('/master/medicine-type/select', [App\Http\Controllers\Master\MedicineTypeController::class, 'select'])->name('medicine-type.select');
Route::resource('master/medicine-type', App\Http\Controllers\Master\MedicineTypeController::class);

Route::post('/master/medicine/datatable', [App\Http\Controllers\Master\MedicineController::class, 'datatable'])->name('medicine.datatable');
Route::post('/master/medicine/datatable/select', [App\Http\Controllers\Master\MedicineController::class, 'datatableSelect'])->name('medicine.datatable.select');
Route::get('/master/medicine/select', [App\Http\Controllers\Master\MedicineController::class, 'select'])->name('medicine.select');
Route::resource('master/medicine', App\Http\Controllers\Master\MedicineController::class);

Route::post('/master/clinic/datatable', [App\Http\Controllers\Master\ClinicController::class, 'datatable'])->name('clinic.datatable');
Route::post('/master/clinic/datatable/select', [App\Http\Controllers\Master\ClinicController::class, 'datatableSelect'])->name('clinic.datatable.select');
Route::get('/master/clinic/select', [App\Http\Controllers\Master\ClinicController::class, 'select'])->name('clinic.select');
Route::resource('master/clinic', App\Http\Controllers\Master\ClinicController::class);

Route::post('/master/period/datatable', [App\Http\Controllers\Master\PeriodController::class, 'datatable'])->name('period.datatable');
Route::post('/master/period/datatable/select', [App\Http\Controllers\Master\PeriodController::class, 'datatableSelect'])->name('period.datatable.select');
Route::get('/master/period/select', [App\Http\Controllers\Master\PeriodController::class, 'select'])->name('period.select');
Route::resource('master/period', App\Http\Controllers\Master\PeriodController::class);

Route::post('/master/symptom/datatable', [App\Http\Controllers\Master\SymptomController::class, 'datatable'])->name('symptom.datatable');
Route::post('/master/symptom/datatable/select', [App\Http\Controllers\Master\SymptomController::class, 'datatableSelect'])->name('symptom.datatable.select');
Route::get('/master/symptom/select', [App\Http\Controllers\Master\SymptomController::class, 'select'])->name('symptom.select');
Route::resource('master/symptom', App\Http\Controllers\Master\SymptomController::class);

Route::post('/master/disease-group/datatable', [App\Http\Controllers\Master\DiseaseGroupController::class, 'datatable'])->name('disease-group.datatable');
Route::post('/master/disease-group/datatable/select', [App\Http\Controllers\Master\DiseaseGroupController::class, 'datatableSelect'])->name('disease-group.datatable.select');
Route::get('/master/disease-group/select', [App\Http\Controllers\Master\DiseaseGroupController::class, 'select'])->name('disease-group.select');
Route::resource('master/disease-group', App\Http\Controllers\Master\DiseaseGroupController::class);

Route::post('/master/estate/datatable', [App\Http\Controllers\Master\EstateController::class, 'datatable'])->name('estate.datatable');
Route::post('/master/estate/datatable/select', [App\Http\Controllers\Master\EstateController::class, 'datatableSelect'])->name('estate.datatable.select');
Route::get('/master/estate/select', [App\Http\Controllers\Master\EstateController::class, 'select'])->name('estate.select');
Route::resource('master/estate', App\Http\Controllers\Master\EstateController::class);

Route::post('/master/afdelink/datatable', [App\Http\Controllers\Master\AfdelinkController::class, 'datatable'])->name('afdelink.datatable');
Route::post('/master/afdelink/datatable/select', [App\Http\Controllers\Master\AfdelinkController::class, 'datatableSelect'])->name('afdelink.datatable.select');
Route::get('/master/afdelink/select', [App\Http\Controllers\Master\AfdelinkController::class, 'select'])->name('afdelink.select');
Route::resource('master/afdelink', App\Http\Controllers\Master\AfdelinkController::class);

Route::post('/master/disease/datatable', [App\Http\Controllers\Master\DiseaseController::class, 'datatable'])->name('disease.datatable');
Route::post('/master/disease/datatable/select', [App\Http\Controllers\Master\DiseaseController::class, 'datatableSelect'])->name('disease.datatable.select');
Route::get('/master/disease/select', [App\Http\Controllers\Master\DiseaseController::class, 'select'])->name('disease.select');
Route::resource('master/disease', App\Http\Controllers\Master\DiseaseController::class);

Route::post('/master/diagnosis/datatable', [App\Http\Controllers\Master\DiagnosisController::class, 'datatable'])->name('diagnosis.datatable');
Route::post('/master/diagnosis/datatable/select', [App\Http\Controllers\Master\DiagnosisController::class, 'datatableSelect'])->name('diagnosis.datatable.select');
Route::get('/master/diagnosis/select', [App\Http\Controllers\Master\DiagnosisController::class, 'select'])->name('diagnosis.select');
Route::resource('master/diagnosis', App\Http\Controllers\Master\DiagnosisController::class);

Route::post('/master/diagnosis-symptom/datatable', [App\Http\Controllers\Master\DiagnosisSymptomController::class, 'datatable'])->name('diagnosis-symptom.datatable');
Route::post('/master/diagnosis-symptom/datatable/select', [App\Http\Controllers\Master\DiagnosisSymptomController::class, 'datatableSelect'])->name('diagnosis-symptom.datatable.select');
Route::get('/master/diagnosis-symptom/select', [App\Http\Controllers\Master\DiagnosisSymptomController::class, 'select'])->name('diagnosis-symptom.select');
Route::resource('master/diagnosis-symptom', App\Http\Controllers\Master\DiagnosisSymptomController::class);

Route::post('/master/disease-medicine/datatable', [App\Http\Controllers\Master\DiseaseMedicineController::class, 'datatable'])->name('disease-medicine.datatable');
Route::post('/master/disease-medicine/datatable/select', [App\Http\Controllers\Master\DiseaseMedicineController::class, 'datatableSelect'])->name('disease-medicine.datatable.select');
Route::get('/master/disease-medicine/select', [App\Http\Controllers\Master\DiseaseMedicineController::class, 'select'])->name('disease-medicine.select');
Route::resource('master/disease-medicine', App\Http\Controllers\Master\DiseaseMedicineController::class);

Route::post('/master/reference/datatable', [App\Http\Controllers\Master\ReferenceController::class, 'datatable'])->name('reference.datatable');
Route::post('/master/reference/datatable/select', [App\Http\Controllers\Master\ReferenceController::class, 'datatableSelect'])->name('reference.datatable.select');
Route::get('/master/reference/select', [App\Http\Controllers\Master\ReferenceController::class, 'select'])->name('reference.select');
Route::resource('master/reference', App\Http\Controllers\Master\ReferenceController::class);

Route::post('/master/medical-staff/datatable', [App\Http\Controllers\Master\MedicalStaffController::class, 'datatable'])->name('medical-staff.datatable');
Route::post('/master/medical-staff/datatable/select', [App\Http\Controllers\Master\MedicalStaffController::class, 'datatableSelect'])->name('medical-staff.datatable.select');
Route::get('/master/medical-staff/select', [App\Http\Controllers\Master\MedicalStaffController::class, 'select'])->name('medical-staff.select');
Route::resource('master/medical-staff', App\Http\Controllers\Master\MedicalStaffController::class);

Route::post('/inventory/stock-opname/datatable', [App\Http\Controllers\Inventory\StockOpnameController::class, 'datatable'])->name('stock-opname.datatable');
Route::resource('inventory/stock-opname', App\Http\Controllers\Inventory\StockOpnameController::class);

Route::post('/inventory/stock-transaction/datatable', [App\Http\Controllers\Inventory\StockTransactionController::class, 'datatable'])->name('stock-transaction.datatable');
Route::post('/inventory/stock-transaction/datatable/select', [App\Http\Controllers\Inventory\StockTransactionController::class, 'datatableSelect'])->name('stock-transaction.datatable.select');
Route::get('/inventory/stock-transaction/select', [App\Http\Controllers\Inventory\StockTransactionController::class, 'select'])->name('stock-transaction.select');
Route::resource('inventory/stock-transaction', App\Http\Controllers\Inventory\StockTransactionController::class);

Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
    Route::post('stock/datatable', [App\Http\Controllers\Report\StockReportController::class, 'datatable'])->name('stock.datatable');
    Route::get('stock/download/{id}', [App\Http\Controllers\Report\StockReportController::class, 'download'])->name('stock.download');
    Route::resource('stock', App\Http\Controllers\Report\StockReportController::class);
});

Route::post('/letter/sick-letter/datatable', [App\Http\Controllers\Letter\SickLetterController::class, 'datatable'])->name('sick-letter.datatable');
Route::get('letter/sick-letter/download/{id}', [App\Http\Controllers\Letter\SickLetterController::class, 'download'])->name('sick-letter.download');
Route::resource('letter/sick-letter', App\Http\Controllers\Letter\SickLetterController::class);
Route::post('/letter/reference-letter/datatable', [App\Http\Controllers\Letter\ReferenceLetterController::class, 'datatable'])->name('reference-letter.datatable');
Route::get('letter/reference-letter/download/{id}', [App\Http\Controllers\Letter\ReferenceLetterController::class, 'download'])->name('reference-letter.download');
Route::resource('letter/reference-letter', App\Http\Controllers\Letter\ReferenceLetterController::class);