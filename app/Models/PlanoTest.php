<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class PlanoTest extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['transaction_no', 'transaction_date', 'remark', 'clinic_id', 'medical_staff_id', 'patient_id', 'reference_type', 'reference_id', 'reference_clinic_id','for_relationship', 'patient_relationship_id', 'result', 'pregnancy_num'];

    public function clinic() {
        return $this->belongsTo(Clinic::class);
    }

    public function medicalStaff() {
        return $this->belongsTo(MedicalStaff::class);
    }

    public function reference() {
        return $this->belongsTo(Reference::class);
    }

    public function referenceClinic() {
        return $this->belongsTo(Clinic::class, 'reference_clinic_id');
    }

    public function patient() {
        return $this->belongsTo(Employee::class, 'patient_id');
    }

    public function patientRelationship() {
        return $this->belongsTo(EmployeeRelationship::class, 'patient_relationship_id');
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['medicalStaff','clinic', 'reference', 'patient', 'referenceClinic','patientRelationship']);
    }
}
