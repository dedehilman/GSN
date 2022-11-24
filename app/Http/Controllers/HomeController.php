<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Lang;
use App\Traits\RuleQueryBuilderTrait;

class HomeController extends Controller
{
    use RuleQueryBuilderTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if(!$request->dateFrom || !$request->dateTo) {
            $dateFrom = Carbon::now()->firstOfMonth()->isoFormat("YYYY-MM-DD");
            $dateTo = Carbon::now()->endOfMonth()->isoFormat("YYYY-MM-DD");    
        } else {
            $dateFrom = $request->dateFrom;
            $dateTo = $request->dateTo;
        }

        $topDiseaseDatas = \App\Models\DiagnosisResult::select("diseases.code", DB::raw("count(*) as total"))
                        ->join('diagnoses', 'diagnoses.id', '=', 'diagnosis_results.diagnosis_id')
                        ->join('diseases', 'diseases.id', '=', 'diagnoses.disease_id')
                        ->join('outpatients', 'outpatients.id', '=', 'diagnosis_results.model_id')
                        ->join('clinics', 'outpatients.clinic_id', '=', 'clinics.id')
                        ->whereDate('transaction_date', '>=', $dateFrom)
                        ->whereDate('transaction_date', '<=', $dateTo)
                        ->groupBy('diseases.code')
                        ->orderBy('total', 'DESC')
                        ->limit(10)
                        ->whereNotNull('diagnoses.disease_id');
        $topDiseaseDatas = $this->queryBuilder(['clinics'], $topDiseaseDatas)->get();        
        $label = array();
        $data = array();

        foreach ($topDiseaseDatas as $topDiseaseData) {
            array_push($label, $topDiseaseData->code);
            array_push($data, $topDiseaseData->total);
        }

        $topDiseases = [
            'label'=> $label,
            'data'=> $data,
        ];

        // KK
        $ids = \App\Models\WorkAccidentCategory::orderBy('id', 'ASC')->pluck('id')->toArray();
        $label = \App\Models\WorkAccidentCategory::orderBy('id', 'ASC')->pluck('name')->toArray();
        $data = array();
        for ($i=0; $i < count($label); $i++) { 
            array_push($data, 0);
        }
        $dataFromDb = \App\Models\WorkAccident::select(
                    'work_accident_category_id',
                    DB::Raw('COUNT(1) AS count')
                )
                ->whereDate('transaction_date', '>=', $dateFrom)
                ->whereDate('transaction_date', '<=', $dateTo)
				->whereNotNull('work_accident_category_id')
                ->groupBy('work_accident_category_id');
        $dataFromDb = $this->queryBuilder(['work_accidents'], $dataFromDb)->get();

        foreach($dataFromDb as $db)
        {
            $data[array_search($db->work_accident_category_id, $ids)] = $db->count;
        }

        $kkBasedOnCategory = [
            'label'=> $label,
            'data'=> $data,
        ];

        // KB
        $ids = \App\Models\FamilyPlanningCategory::orderBy('id', 'ASC')->pluck('id')->toArray();
        $label = \App\Models\FamilyPlanningCategory::orderBy('id', 'ASC')->pluck('name')->toArray();
        $data = array();
        for ($i=0; $i < count($label); $i++) { 
            array_push($data, 0);
        }
        $dataFromDb = \App\Models\FamilyPlanning::select(
                    'family_planning_category_id',
                    DB::Raw('COUNT(1) AS count')
                )
                ->whereDate('transaction_date', '>=', $dateFrom)
                ->whereDate('transaction_date', '<=', $dateTo)
				->whereNotNull('family_planning_category_id')
                ->groupBy('family_planning_category_id');
        $dataFromDb = $this->queryBuilder(['family_plannings'], $dataFromDb)->get();

        foreach($dataFromDb as $db)
        {
            $data[array_search($db->family_planning_category_id, $ids)] = $db->count;
        }

        $kbBasedOnCategory = [
            'label'=> $label,
            'data'=> $data,
        ];

        // PP
        $label = [Lang::get('Positive'), Lang::get('Negative')];
        $data = array();
        for ($i=0; $i < count($label); $i++) { 
            array_push($data, 0);
        }
        $dataFromDb = \App\Models\PlanoTest::select(
                    'result',
                    DB::Raw('COUNT(1) AS count')
                )
                ->whereDate('transaction_date', '>=', $dateFrom)
                ->whereDate('transaction_date', '<=', $dateTo)
				->whereNotNull('result')
                ->groupBy('result');
        $dataFromDb = $this->queryBuilder(['plano_tests'], $dataFromDb)->get();

        foreach($dataFromDb as $db)
        {
            $data[array_search($db->label, $label)] = $db->count;
        }

        $ppTestBasedOnResult = [
            'label'=> $label,
            'data'=> $data,
        ];

        // Sick Letter
        $ids = \App\Models\Clinic::orderBy('id', 'ASC');
        $ids = $this->queryBuilder(['clinics'], $ids)->pluck('id')->toArray();
        $label = \App\Models\Clinic::orderBy('id', 'ASC');
        $label = $this->queryBuilder(['clinics'], $label)->pluck('code')->toArray();

        $data = array();
        for ($i=0; $i < count($label); $i++) { 
            array_push($data, 0);
        }
        $dataFromDb = \App\Models\SickLetter::select(
                    'clinic_id',
                    DB::Raw('COUNT(1) AS count')
                )
                ->whereDate('transaction_date', '>=', $dateFrom)
                ->whereDate('transaction_date', '<=', $dateTo)
                ->groupBy('clinic_id')
                ->get();

        foreach($dataFromDb as $db)
        {
            $data[array_search($db->clinic_id, $ids)] = $db->count;
        }

        $slBasedOnClinic = [
            'label'=> $label,
            'data'=> $data,
        ];

        // Reference Letter
        $data = array();
        for ($i=0; $i < count($label); $i++) { 
            array_push($data, 0);
        }
        $dataFromDb = \App\Models\ReferenceLetter::select(
                    'clinic_id',
                    DB::Raw('COUNT(1) AS count')
                )
                ->whereDate('transaction_date', '>=', $dateFrom)
                ->whereDate('transaction_date', '<=', $dateTo)
                ->groupBy('clinic_id')
                ->get();

        foreach($dataFromDb as $db)
        {
            $data[array_search($db->clinic_id, $ids)] = $db->count;
        }

        $rlBasedOnClinic = [
            'label'=> $label,
            'data'=> $data,
        ];

        $patient = DB::table('employees');
        $patient = $this->queryBuilder(['employees'], $patient);
        $patientCount = $patient->count();
        $activePatientCount = DB::select("
                            SELECT COUNT(DISTINCT patient_id) AS count FROM
                            (
                                SELECT patient_id FROM family_plannings
                                UNION ALL
                                SELECT patient_id FROM outpatients
                                UNION ALL
                                SELECT patient_id FROM plano_tests
                                UNION ALL
                                SELECT patient_id FROM work_accidents
                                UNION ALL
                                SELECT patient_id FROM sick_letters
                                UNION ALL
                                SELECT patient_id FROM reference_letters
                            ) a
                            WHERE a.patient_id IN (".implode(",", $patient->pluck("id")->toArray()).")");

        $medicalStaffCount = DB::table('medical_staff');
        $medicalStaffCount = $this->queryBuilder(['medical_staff'], $medicalStaffCount)->count();
        $q1 = \App\Models\Prescription::select("prescriptions.medicine_id", DB::raw("count(*) as total"))
                ->join('outpatients', function ($join) {
                    $join->on('prescriptions.model_id', '=', 'outpatients.id');
                    $join->on('prescriptions.model_type', '=', DB::Raw('"App\\\\Models\\\\Outpatient"'));
                })
                ->whereDate('transaction_date', '>=', $dateFrom)
                ->whereDate('transaction_date', '<=', $dateTo)
                ->groupBy('prescriptions.medicine_id');
        $q1 = $this->queryBuilder(['outpatients'], $q1);
        $q2 = \App\Models\Prescription::select("prescriptions.medicine_id", DB::raw("count(*) as total"))
                ->join('family_plannings', function ($join) {
                    $join->on('prescriptions.model_id', '=', 'family_plannings.id');
                    $join->on('prescriptions.model_type', '=', DB::Raw('"App\\\\Models\\\\FamilyPlanning"'));
                })
                ->whereDate('transaction_date', '>=', $dateFrom)
                ->whereDate('transaction_date', '<=', $dateTo)
                ->groupBy('prescriptions.medicine_id');
        $q2 = $this->queryBuilder(['family_plannings'], $q2);
        $q3 = \App\Models\Prescription::select("prescriptions.medicine_id", DB::raw("count(*) as total"))
                ->join('plano_tests', function ($join) {
                    $join->on('prescriptions.model_id', '=', 'plano_tests.id');
                    $join->on('prescriptions.model_type', '=', DB::Raw('"App\\\\Models\\\\PlanoTest"'));
                })
                ->whereDate('transaction_date', '>=', $dateFrom)
                ->whereDate('transaction_date', '<=', $dateTo)
                ->groupBy('prescriptions.medicine_id');
        $q3 = $this->queryBuilder(['plano_tests'], $q3);
        $q4 = \App\Models\Prescription::select("prescriptions.medicine_id", DB::raw("count(*) as total"))
                ->join('work_accidents', function ($join) {
                    $join->on('prescriptions.model_id', '=', 'work_accidents.id');
                    $join->on('prescriptions.model_type', '=', DB::Raw('"App\\\\Models\\\\WorkAccident"'));
                })
                ->whereDate('transaction_date', '>=', $dateFrom)
                ->whereDate('transaction_date', '<=', $dateTo)
                ->groupBy('prescriptions.medicine_id');
        $q4 = $this->queryBuilder(['work_accidents'], $q4);
        $topMedicines = DB::table('medicines')
                        ->select('medicines.name',DB::raw("sum(total) as total"))
                        ->joinSub($q1->unionAll($q2)->unionAll($q3)->unionAll($q4), 'sq', 'medicines.id', 'sq.medicine_id')
                        ->groupBy('medicines.name')
                        ->limit(10)
                        ->orderBy('total', 'desc')
                        ->get();
        
        return view('home', [
            "topDiseases"=>$topDiseases,
            "kkBasedOnCategory"=>$kkBasedOnCategory,
            "kbBasedOnCategory"=>$kbBasedOnCategory,
            "ppTestBasedOnResult"=>$ppTestBasedOnResult,
            "slBasedOnClinic"=>$slBasedOnClinic,
            "rlBasedOnClinic"=>$rlBasedOnClinic,
            "patientCount"=>$patientCount,
            "medicalStaffCount"=>$medicalStaffCount,
            "topMedicines"=>$topMedicines,
            "activePatientCount"=>$activePatientCount[0]->count ?? 0,
        ]);
    }
}
