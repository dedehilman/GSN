<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class Node extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['route_id', 'node_type', 'node_owner_type', 'connector1', 'connector2', 'position_top', 'position_left', 'next_node1_id', 'next_node2_id'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
            $data->nodeOwners()->delete();
            $data->nodeNotifications()->delete();
        });
    }

    public function route() {
        return $this->belongsTo(Route::class);
    }

    public function nodeOwners() {
        return $this->hasMany(NodeOwner::class);
    }

    public function nodeNotifications() {
        return $this->hasMany(NodeNotification::class);
    }

    public function syncNodeOwners($nodeOwners)
    {
        $this->nodeOwners()->delete();   
        for ($i=0; $i < count($nodeOwners); $i++) { 
            $this->nodeOwners()->save($nodeOwners[$i]);
        }
    }

    public function syncNodeNotifications($nodeNotifications)
    {
        $this->nodeNotifications()->delete();   
        for ($i=0; $i < count($nodeNotifications); $i++) { 
            $this->nodeNotifications()->save($nodeNotifications[$i]);
        }
    }
    
}
