<?php

namespace App\Traits;

use App\Observers\BlameableObserver;

trait BlameableTrait 
{

    public static function bootBlameableTrait() 
    {
        static::observe(BlameableObserver::class);
    }
    
}