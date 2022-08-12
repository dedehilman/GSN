<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class DiagnosisSymptomResult extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['diagnosis_result_id', 'symptom_id'];

    public function symptom() {
        return $this->belongsTo(Symptom::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['symptom']);
    }
}
