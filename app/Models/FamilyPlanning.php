<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class FamilyPlanning extends Model implements HasMedia
{
    use HasFactory, BlameableTrait, InteractsWithMedia;

    protected $fillable = ['transaction_no', 'transaction_date', 'remark', 'clinic_id', 'medical_staff_id', 'patient_id', 'reference_type', 'reference_id', 'reference_clinic_id','for_relationship', 'patient_relationship_id', 'family_planning_category_id', 'installation_date'];

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

    public function familyPlanningCategory() {
        return $this->belongsTo(FamilyPlanningCategory::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['medicalStaff','clinic', 'reference', 'patient', 'referenceClinic','patientRelationship', 'familyPlanningCategory']);
    }
}