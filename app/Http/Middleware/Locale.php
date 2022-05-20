<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Carbon\Carbon;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Session::put('locale', getAppearance()->language ?? 'id');

        if ($request->has('locale')) {
            if (in_array(strtolower($request->locale), ['en', 'id'])) {
                session()->put('locale', $request->locale);
            } else {
                session()->put('locale', 'id');
            }
        }

        if(session()->has('locale')) {
            app()->setLocale(session('locale'));
            Carbon::setLocale(session('locale'));
        }

        return $next($request);
    }
}