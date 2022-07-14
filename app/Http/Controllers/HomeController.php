<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        return view('home', ["topDiseases"=>$topDiseases]);
    }
}
