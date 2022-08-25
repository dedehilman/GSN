<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'as' => 'v1.' ], function () {
    Route::post('auth/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('auth/forgot-password', [App\Http\Controllers\Api\AuthController::class, 'forgotPassword']);
    Route::post('auth/reset-password', [App\Http\Controllers\Api\AuthController::class, 'resetPassword']);
    Route::middleware('auth:api')->post('auth/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::middleware('auth:api')->post('auth/change-password', [App\Http\Controllers\Api\AuthController::class, 'changePassword']);
    Route::middleware('auth:api')->get('auth/user', [App\Http\Controllers\Api\AuthController::class, 'user']);

    Route::apiResource('patients', App\Http\Controllers\Api\PatientController::class);
    Route::apiResource('patient/relationships', App\Http\Controllers\Api\PatientRelationshipController::class);
    Route::apiResource('medical-staff', App\Http\Controllers\Api\MedicalStaffController::class);
    Route::apiResource('clinics', App\Http\Controllers\Api\ClinicController::class);
    Route::apiResource('references', App\Http\Controllers\Api\ReferenceController::class);
    Route::apiResource('parameters', App\Http\Controllers\Api\ParameterController::class);
    Route::get('diagnoses/calculate', [App\Http\Controllers\Api\DiagnosisController::class, 'calculate']);
    Route::apiResource('diagnoses', App\Http\Controllers\Api\DiagnosisController::class);
    Route::apiResource('family-planning-categories', App\Http\Controllers\Api\FamilyPlanningCategoryController::class);
    Route::apiResource('work-accident-categories', App\Http\Controllers\Api\WorkAccidentCategoryController::class);
    Route::apiResource('medicines', App\Http\Controllers\Api\MedicineController::class);
    Route::apiResource('medicine-rules', App\Http\Controllers\Api\MedicineRuleController::class);
    Route::apiResource('histories', App\Http\Controllers\Api\HistoryController::class);
    Route::get('pharmacies/unprocessed', [App\Http\Controllers\Api\PharmacyController::class, 'unprocessed']);
    Route::apiResource('pharmacies', App\Http\Controllers\Api\PharmacyController::class);
    Route::apiResource('prescriptions', App\Http\Controllers\Api\PrescriptionController::class);
    Route::apiResource('symptoms', App\Http\Controllers\Api\SymptomController::class);
    Route::apiResource('diseases/medicines', App\Http\Controllers\Api\DiseaseMedicineController::class);

    Route::group(['prefix' => 'letter/', 'as' => 'letter.' ], function () {
        Route::get('references/send-to-email', [App\Http\Controllers\Api\Letter\ReferenceLetterController::class, 'sendToEmail']);
        Route::post('references/generate', [App\Http\Controllers\Api\Letter\ReferenceLetterController::class, 'generate']);
        Route::apiResource('references', App\Http\Controllers\Api\Letter\ReferenceLetterController::class);
        Route::get('sicks/send-to-email', [App\Http\Controllers\Api\Letter\SickLetterController::class, 'sendToEmail']);
        Route::post('sicks/generate', [App\Http\Controllers\Api\Letter\SickLetterController::class, 'generate']);
        Route::apiResource('sicks', App\Http\Controllers\Api\Letter\SickLetterController::class);
    });

    Route::group(['prefix' => 'registration/', 'as' => 'registration.' ], function () {
        Route::apiResource('plano-tests', App\Http\Controllers\Api\Registration\PlanoTestController::class);
        Route::apiResource('family-plannings', App\Http\Controllers\Api\Registration\FamilyPlanningController::class);
        Route::apiResource('outpatients', App\Http\Controllers\Api\Registration\OutpatientController::class);
        Route::apiResource('work-accidents', App\Http\Controllers\Api\Registration\WorkAccidentController::class);
    });

    Route::group(['prefix' => 'action/', 'as' => 'action.' ], function () {
        Route::get('plano-tests/send-to-email', [App\Http\Controllers\Api\Action\PlanoTestController::class, 'sendToEmail']);
        Route::post('plano-tests/media', [App\Http\Controllers\Api\Action\PlanoTestController::class, 'storeMedia']);
        Route::post('plano-tests/generate-prescription', [App\Http\Controllers\Api\Action\PlanoTestController::class, 'generatePrescription']);
        Route::apiResource('plano-tests', App\Http\Controllers\Api\Action\PlanoTestController::class);
        Route::post('family-plannings/media', [App\Http\Controllers\Api\Action\FamilyPlanningController::class, 'storeMedia']);
        Route::post('family-plannings/generate-prescription', [App\Http\Controllers\Api\Action\FamilyPlanningController::class, 'generatePrescription']);
        Route::apiResource('family-plannings', App\Http\Controllers\Api\Action\FamilyPlanningController::class);
        Route::post('outpatients/media', [App\Http\Controllers\Api\Action\OutpatientController::class, 'storeMedia']);
        Route::post('outpatients/generate-prescription', [App\Http\Controllers\Api\Action\OutpatientController::class, 'generatePrescription']);
        Route::apiResource('outpatients', App\Http\Controllers\Api\Action\OutpatientController::class);
        Route::post('work-accidents/media', [App\Http\Controllers\Api\Action\WorkAccidentController::class, 'storeMedia']);
        Route::post('work-accidents/generate-prescription', [App\Http\Controllers\Api\Action\WorkAccidentController::class, 'generatePrescription']);
        Route::apiResource('work-accidents', App\Http\Controllers\Api\Action\WorkAccidentController::class);
    });
});
