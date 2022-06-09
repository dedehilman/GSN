<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

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

    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class, DiagnosisSymptom::class);
    }

    public function syncSymptoms($symptoms)
    {
        $this->symptoms()->detach();   
        $this->symptoms()->attach($symptoms);
    }
}
