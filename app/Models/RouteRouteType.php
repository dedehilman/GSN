<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class RouteRouteType extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['route_id', 'route_type'];

}
