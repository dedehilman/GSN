<?php

namespace App\Models;

use App\Traits\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['code', 'name', 'handling', 'disease_id'];

    public function disease() {
        return $this->belongsTo(Disease::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['disease']);
    }
}
