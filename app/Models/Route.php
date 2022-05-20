<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class Route extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['name', 'sequence_id', 'sequence_number', 'file_location'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
            $data->routeTypes()->delete();
            $data->nodes()->delete();
            $data->routeNotifications()->delete();
        });
    }

    public function sequence() {
        return $this->belongsTo(Sequence::class);
    }

    public function routeTypes() {
        return $this->hasMany(RouteRouteType::class);
    }

    public function nodes() {
        return $this->hasMany(Node::class);
    }

    public function routeNotifications() {
        return $this->hasMany(RouteNotification::class);
    }

    public function syncRouteTypes($routeTypes)
    {
        $this->routeTypes()->delete();
        for ($i=0; $i < count($routeTypes); $i++) { 
            $this->routeTypes()->save($routeTypes[$i]);
        }
    }

    public function syncNodes($nodes)
    {
        $this->nodes()->delete();
        for ($i=0; $i < count($nodes); $i++) { 
            $this->nodes()->save($nodes[$i]);
        }
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['sequence', 'routeTypes']);
    }
}
