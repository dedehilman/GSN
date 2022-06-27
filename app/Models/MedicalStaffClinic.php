<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class MedicalStaffClinic extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['medical_staff_id', 'clinic_id', 'effective_date', 'expiry_date'];

    public function medicalStaff() {
        return $this->belongsTo(MedicalStaff::class);
    }

    public function clinic() {
        return $this->belongsTo(Clinic::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['medicalStaff','clinic']);
    }
}
