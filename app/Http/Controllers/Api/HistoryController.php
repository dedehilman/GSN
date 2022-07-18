<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\MedicalStaff;
use App\Models\Clinic;
use App\Models\PlanoTest;
use App\Models\FamilyPlanning;
use App\Models\WorkAccident;
use App\Models\Outpatient;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\DB;

class HistoryController extends ApiController
{

    public function __construct()
    {
    }

    public function index(Request $request) {
        try {
            $page = $request->page ?? 0;
            $size = $request->size ?? 10;

            $query1 = PlanoTest::where('patient_id', $request->patient_id)
                    ->select('id', 'patient_id', 'transaction_no', 'transaction_date', 'clinic_id', 'medical_staff_id', DB::Raw('"PP Test" AS service'));
            $query2 = FamilyPlanning::where('patient_id', $request->patient_id)
                    ->select('id', 'patient_id', 'transaction_no', 'transaction_date', 'clinic_id', 'medical_staff_id', DB::Raw('"KB" AS service'));
            $query3 = WorkAccident::where('patient_id', $request->patient_id)
                    ->select('id', 'patient_id', 'transaction_no', 'transaction_date', 'clinic_id', 'medical_staff_id', DB::Raw('"KK" AS service'));
            $query4 = Outpatient::where('patient_id', $request->patient_id)
                    ->select('id', 'patient_id', 'transaction_no', 'transaction_date', 'clinic_id', 'medical_staff_id', DB::Raw('"Rawat Jalan" AS service'));

            $query = $query1
                    ->unionAll($query2)
                    ->unionAll($query3)
                    ->unionAll($query4);

            $totalData = $query->count();
            $query = $this->sortBuilder($request, $query);
            $totalFiltered = $query->count();

            if ($size == -1) {
                $totalPage = 0;
                $data = $query->get();
            } else {
                $totalPage = ceil($totalFiltered / $size);
                if($totalPage > 0) {
                    $totalPage = $totalPage - 1;
                }
                $data = $query
                    ->offset($page * $size)
                    ->limit($size)
                    ->get();
            }

            foreach ($data as $dt) {
                $dt->setAttribute("medical_staff", MedicalStaff::find($dt->medical_staff_id));
                $dt->setAttribute("clinic", Clinic::find($dt->clinic_id));
            }

            return response()->json([
                "status" => '200',
                "message" => '',
                "data" => array(
                    "page" => intval($page),
                    "size" => intval($size),
                    "total_page" => intval($totalPage),
                    "total_data" => intval($totalData),
                    "total_filtered" => intval($totalFiltered),
                    "data" => $data    
                )
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => '500',
                'data' => '',
                'message'=> $th->getMessage()
            ]);
        }
        
    }
}
