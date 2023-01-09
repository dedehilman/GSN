<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class TreatmentHistory extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = [
        'code', 
        'file_path', 
        'message', 
        'runned_at', 
        'finished_at', 
        'status', 
        'num_of_downloaded',
        'patient_id',
    ];
    
    public function patient() {
        return $this->belongsTo(Employee::class, 'patient_id');
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['patient']);
    }
}
