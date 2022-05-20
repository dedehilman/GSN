<?php

namespace App\Http\Middleware;

use Closure;
use Tree\Node\Node;
use Session;
use App\Traits\MenuBuilderTrait;

class MenuBuilder
{
    use MenuBuilderTrait;
    
    public function handle($request, Closure $next)
    {
        if(getCurrentUser() && !Session::has('menu')) {       
            session()->put('menu', $this->buildMenu());
        }
        return $next($request);
    }
}