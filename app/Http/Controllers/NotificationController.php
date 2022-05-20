<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(Request $request){
        $notif = getCurrentUser()->notifications()->find($request->id);
        if($notif) {
            $notif->markAsRead();
            return redirect($notif->data['url']);    
        }
        return redirect()->back();
    }
}
