<?php

namespace App\Models;

use App\Traits\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosisSymptom extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['diagnosis_id', 'symptom_id'];

    public function diagnosis() {
        return $this->belongsTo(Diagnosis::class);
    }

    public function symptom() {
        return $this->belongsTo(Symptom::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['diagnosis', 'symptom']);
    }
}
