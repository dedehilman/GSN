<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppearanceSetting;
use Illuminate\Support\Facades\Validator;
use Lang;

class AppearanceSettingController extends Controller
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
        $data = getAppearance();
        return view('system.appearance-setting', compact('data'));
    }

    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'language' => 'required',
                'sidebar_theme' => 'required',
                'sidebar_variant' => 'required',
                'sidebar_elevation' => 'required',
                'navbar_theme' => 'required',
                'navbar_variant' => 'required',
                'navbar_border' => 'required',
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'status' => '400',
                    'data' => '',
                    'message'=> $validator->errors()->all()
                ]);
            }

            $data = getAppearance();
            if(!$data) {
                $data = new AppearanceSetting();
            }

            $data->user_id = getCurrentUser()->id;
            $data->language = $request->language;
            $data->dark_mode = $request->dark_mode ?? 0;
            $data->sidebar_fixed = $request->sidebar_fixed ?? 0;
            $data->navbar_fixed = $request->navbar_fixed ?? 0;
            $data->footer_fixed = $request->footer_fixed ?? 0;
            $data->sidebar_theme = $request->sidebar_theme;
            $data->sidebar_variant = $request->sidebar_variant;
            $data->sidebar_elevation = $request->sidebar_elevation;
            $data->navbar_theme = $request->navbar_theme;
            $data->navbar_variant = $request->navbar_variant;
            $data->navbar_border = $request->navbar_border;
            $data->small_text = $request->small_text ?? 0;
            $data->sidebar_flat = $request->sidebar_flat ?? 0;
            $data->sidebar_legacy = $request->sidebar_legacy ?? 0;
            $data->sidebar_indent = $request->sidebar_indent ?? 0;
            $data->layout = $request->layout ?? 'sidebar-mini';
            $data->navbar_show_icon = $request->navbar_show_icon ?? 0;
            if($request->image) {
                $file = $request->file('image');
                $destination = 'public/img/user';
                if($file->move($destination, $file->getClientOriginalName())) {
                    $data->image = $destination.'/'.$file->getClientOriginalName();
                };
            }

            $data->save();
            return response()->json([
                'status' => '200',
                'data' => '',
                'message'=> Lang::get("Password has been changed")
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
