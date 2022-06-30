<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class SickLetter extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['transaction_no', 'transaction_date', 'num_of_days', 'remark', 'clinic_id', 'medical_staff_id', 'patient_id'];

    public function clinic() {
        return $this->belongsTo(Clinic::class);
    }

    public function medicalStaff() {
        return $this->belongsTo(MedicalStaff::class);
    }

    public function patient() {
        return $this->belongsTo(Employee::class, 'patient_id');
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['medicalStaff','clinic','patient']);
    }
}
