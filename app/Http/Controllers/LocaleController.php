<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use App\Models\AppearanceSetting;

class LocaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(Request $request){
        Session::put('locale', $request->locale);
        $appearance = getAppearance();
        if($appearance) {
            if($appearance->type == 'global') {
                $newAppearance = new AppearanceSetting();
                $newAppearance->dark_mode = $appearance->dark_mode;
                $newAppearance->sidebar_fixed = $appearance->sidebar_fixed;
                $newAppearance->navbar_fixed = $appearance->navbar_fixed;
                $newAppearance->footer_fixed = $appearance->footer_fixed;
                $newAppearance->sidebar_theme = $appearance->sidebar_theme;
                $newAppearance->sidebar_variant = $appearance->sidebar_variant;
                $newAppearance->sidebar_elevation = $appearance->sidebar_elevation;
                $newAppearance->navbar_theme = $appearance->navbar_theme;
                $newAppearance->navbar_variant = $appearance->navbar_variant;
                $newAppearance->navbar_border = $appearance->navbar_border;
                $newAppearance->small_text = $appearance->small_text;
                $newAppearance->sidebar_flat = $appearance->sidebar_flat;
                $newAppearance->sidebar_legacy = $appearance->sidebar_legacy;
                $newAppearance->sidebar_indent = $appearance->sidebar_indent;
                $newAppearance->layout = $appearance->layout;
                $newAppearance->navbar_show_icon = $appearance->navbar_show_icon;
                $newAppearance->user_id = getCurrentUser()->id;
                $newAppearance->language = $request->locale;
                $newAppearance->save();
            } else {
                $appearance->language = $request->locale;
                $appearance->save();    
            }
        }
        return redirect()->back();
    }
    
}
