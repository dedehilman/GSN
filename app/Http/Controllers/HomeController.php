<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Lang;

class HomeController extends Controller
{
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
    public function index()
    {
        $topDiseaseDatas = \App\Models\DiagnosisResult::select("diseases.code", DB::raw("count(*) as total"))
                        ->join('diagnoses', 'diagnoses.id', '=', 'diagnosis_results.diagnosis_id')
                        ->join('diseases', 'diseases.id', '=', 'diagnoses.disease_id')
                        ->groupBy('diseases.code')
                        ->orderBy('total', 'DESC')
                        ->limit(10)
                        ->whereNotNull('diagnoses.disease_id')
                        ->get();
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
                ->groupBy('work_accident_category_id')
                ->get();

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
                ->groupBy('family_planning_category_id')
                ->get();

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
                ->groupBy('result')
                ->get();

        foreach($dataFromDb as $db)
        {
            $data[array_search($db->label, $label)] = $db->count;
        }

        $ppTestBasedOnResult = [
            'label'=> $label,
            'data'=> $data,
        ];

        // Sick Letter
        $ids = \App\Models\Clinic::orderBy('id', 'ASC')->pluck('id')->toArray();
        $label = \App\Models\Clinic::orderBy('id', 'ASC')->pluck('code')->toArray();
        $data = array();
        for ($i=0; $i < count($label); $i++) { 
            array_push($data, 0);
        }
        $dataFromDb = \App\Models\SickLetter::select(
                    'clinic_id',
                    DB::Raw('COUNT(1) AS count')
                )
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
        $ids = \App\Models\Clinic::orderBy('id', 'ASC')->pluck('id')->toArray();
        $label = \App\Models\Clinic::orderBy('id', 'ASC')->pluck('code')->toArray();
        $data = array();
        for ($i=0; $i < count($label); $i++) { 
            array_push($data, 0);
        }
        $dataFromDb = \App\Models\ReferenceLetter::select(
                    'clinic_id',
                    DB::Raw('COUNT(1) AS count')
                )
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

        return view('home', [
            "topDiseases"=>$topDiseases,
            "kkBasedOnCategory"=>$kkBasedOnCategory,
            "kbBasedOnCategory"=>$kbBasedOnCategory,
            "ppTestBasedOnResult"=>$ppTestBasedOnResult,
            "slBasedOnClinic"=>$slBasedOnClinic,
            "rlBasedOnClinic"=>$rlBasedOnClinic,
        ]);
    }
}
