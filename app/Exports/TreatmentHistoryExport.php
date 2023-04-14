<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\PlanoTest;
use App\Models\FamilyPlanning;
use App\Models\WorkAccident;
use App\Models\Outpatient;
use Illuminate\Support\Facades\DB;

class TreatmentHistoryExport implements ShouldAutoSize, FromView
{
    use Exportable;

    private $reportModel;

    public function __construct($reportModel)
    {
        app()->setLocale(getCurrentUser()->appearance->language ?? 'id');
        $this->reportModel = $reportModel;
    }

    public function view(): View
    {
        $query1 = PlanoTest::where('patient_id', $this->reportModel->patient_id)
                ->join('actions', function ($join) {
                    $join->on('actions.model_id', '=', 'plano_tests.id');
                    $join->on('actions.model_type', '=', DB::Raw('"App\\\\Models\\\\PlanoTest"'));
                })
                ->leftJoin('clinics', 'clinics.id', '=', 'plano_tests.reference_clinic_id')
                ->leftJoin('references', 'references.id', '=', 'plano_tests.reference_id')
                ->select('plano_tests.id', 'transaction_date', 'plano_tests.reference_type', 'clinics.code AS reference_clinic', 'references.name AS reference', DB::Raw('"PP Test" AS service'), 'plano_tests.for_relationship', 'plano_tests.patient_relationship_id');
        $query2 = FamilyPlanning::where('patient_id', $this->reportModel->patient_id)
                ->join('actions', function ($join) {
                    $join->on('actions.model_id', '=', 'family_plannings.id');
                    $join->on('actions.model_type', '=', DB::Raw('"App\\\\Models\\\\FamilyPlanning"'));
                })
                ->leftJoin('clinics', 'clinics.id', '=', 'family_plannings.reference_clinic_id')
                ->leftJoin('references', 'references.id', '=', 'family_plannings.reference_id')
                ->select('family_plannings.id', 'transaction_date', 'family_plannings.reference_type', 'clinics.code AS reference_clinic', 'references.name AS reference', DB::Raw('"KB" AS service'), 'family_plannings.for_relationship', 'family_plannings.patient_relationship_id');
        $query3 = WorkAccident::where('patient_id', $this->reportModel->patient_id)
                ->join('actions', function ($join) {
                    $join->on('actions.model_id', '=', 'work_accidents.id');
                    $join->on('actions.model_type', '=', DB::Raw('"App\\\\Models\\\\WorkAccident"'));
                })
                ->leftJoin('clinics', 'clinics.id', '=', 'work_accidents.reference_clinic_id')
                ->leftJoin('references', 'references.id', '=', 'work_accidents.reference_id')
                ->select('work_accidents.id', 'transaction_date', 'work_accidents.reference_type', 'clinics.code AS reference_clinic', 'references.name AS reference', DB::Raw('"KK" AS service'), 'work_accidents.for_relationship', 'work_accidents.patient_relationship_id');
        $query4 = Outpatient::where('patient_id', $this->reportModel->patient_id)
                ->join('actions', function ($join) {
                    $join->on('actions.model_id', '=', 'outpatients.id');
                    $join->on('actions.model_type', '=', DB::Raw('"App\\\\Models\\\\Outpatient"'));
                })
                ->leftJoin('clinics', 'clinics.id', '=', 'outpatients.reference_clinic_id')
                ->leftJoin('references', 'references.id', '=', 'outpatients.reference_id')
                ->select('outpatients.id', 'transaction_date', 'outpatients.reference_type', 'clinics.code AS reference_clinic', 'references.name AS reference', DB::Raw('"Rawat Jalan" AS service'), 'outpatients.for_relationship', 'outpatients.patient_relationship_id');

        $datas = $query1
                ->unionAll($query2)
                ->unionAll($query3)
                ->unionAll($query4)
                ->orderBy('transaction_date', 'DESC')
                ->get();

        foreach ($datas as $data) {
            $class = "App\Models\Outpatient";
            if($data->service == "PP Test") {
                $class = "App\Models\PlanoTest";
            } else if($data->service == "KB") {
                $class = "App\Models\FamilyPlanning";
            } else if($data->service == "KK") {
                $class = "App\Models\WorkAccident";
            } else if($data->service == "Rawat Jalan") {
                $class = "App\Models\Outpatient";
            }
            $diagnoses = \App\Models\DiagnosisResult::with("diagnosis","symptoms")->where('model_type', $class)
            ->where('model_id', $data->id)
            ->get();
            $action = \App\Models\Action::with("reference","referenceClinic")->where('model_type', $class)
            ->where('model_id', $data->id)
            ->first();
            $prescriptions = \App\Models\Prescription::with("medicine", "medicineRule")->where('model_type', $class)
            ->where('model_id', $data->id)
            ->get();
            $data->setAttribute("diagnoses", $diagnoses);
            $data->setAttribute("action", $action);
            $data->setAttribute("prescriptions", $prescriptions);

            $patientRelation = null;
            if($data->patient_relationship_id) {
                $patientRelation = \App\Models\EmployeeRelationship::find($data->patient_relationship_id);
            }
            $data->setAttribute("patientRelation", $patientRelation);
        }

        return view('report.treatment-history.template', [
            "reportModel"=> $this->reportModel,
            "datas"=> $datas,
        ]);
    }
}
