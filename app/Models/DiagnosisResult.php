<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class DiagnosisResult extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['model_id', 'model_type_id', 'diagnosis_id'];

    public function diagnosis() {
        return $this->belongsTo(Diagnosis::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['diagnosis']);
    }
}
