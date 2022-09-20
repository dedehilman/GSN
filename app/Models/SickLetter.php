<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class SickLetter extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['transaction_no', 'transaction_date', 'num_of_days', 'remark', 'clinic_id', 'medical_staff_id', 'patient_id', 'for_relationship', 'patient_relationship_id', 'diagnosis_id', 'model_id', 'model_type'];

    public function clinic() {
        return $this->belongsTo(Clinic::class);
    }

    public function medicalStaff() {
        return $this->belongsTo(MedicalStaff::class);
    }

    public function patient() {
        return $this->belongsTo(Employee::class, 'patient_id');
    }

    public function patientRelationship() {
        return $this->belongsTo(EmployeeRelationship::class, 'patient_relationship_id');
    }

    public function diagnosis() {
        return $this->belongsTo(Diagnosis::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['medicalStaff','clinic','patient','patientRelationship','diagnoses']);
    }

    // public function diagnosis() {
    //     return $this->belongsTo(Diagnosis::class);
    // }

    public function diagnoses()
    {
        return $this->belongsToMany(Diagnosis::class, SickLetterDiagnosis::class);
    }

    public function syncDiagnoses($diagnoses)
    {
        $this->diagnoses()->detach();   
        $this->diagnoses()->attach($diagnoses);
    }
}
