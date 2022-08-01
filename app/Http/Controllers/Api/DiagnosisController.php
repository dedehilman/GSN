<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DiagnosisController extends ApiController
{

    public function __construct()
    {
        $this->setDefaultMiddleware('diagnosis');
        $this->setModel('App\Models\Diagnosis');
    }

    public function calculate(Request $request) {
        try
        {
            $data = DB::select('SELECT a.id,a.code,a.name, ROUND((COALESCE(b.matchCount, 0) / COALESCE(c.totalCount, 0) * 100), 0) AS percentage FROM diagnoses a LEFT JOIN ( SELECT diagnosis_id,COUNT(1) AS matchCount FROM diagnosis_symptoms WHERE symptom_id IN ('.implode(",", $request->symptom_id ?? []).') GROUP BY diagnosis_id ) b ON a.id = b.diagnosis_id LEFT JOIN (SELECT diagnosis_id,COUNT(1) AS totalCount FROM diagnosis_symptoms GROUP BY diagnosis_id) c ON a.id = c.diagnosis_id WHERE matchCount >= '.count($request->symptom_id ?? []). ' ORDER BY percentage DESC');
            $totalData = count($data);
            $totalFiltered = $totalData;
            
            return response()->json([
                "status" => '200',
                "message" => '',
                "data" => array(
                    "page" => 0,
                    "size" => 10,
                    "total_page" => 0,
                    "total_data" => intval($totalData),
                    "total_filtered" => intval($totalFiltered),
                    "data" => $data    
                )
            ]);
        } 
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => '500',
                'data' => '',
                'message' => $th->getMessage()
            ]);
        }
    }
}
