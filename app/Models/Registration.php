<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class Registration extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['registration_no', 'registration_date','registration_type','reference_id','clinic_id','medical_staff_id','patient_id'];

    public function clinic() {
        return $this->belongsTo(Clinic::class);
    }

    public function medicalStaff() {
        return $this->belongsTo(MedicalStaff::class);
    }

    public function reference() {
        return $this->belongsTo(Reference::class);
    }

    public function patient() {
        return $this->belongsTo(Employee::class, 'patient_id');
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['medicalStaff','clinic', 'reference', 'patient']);
    }
}
