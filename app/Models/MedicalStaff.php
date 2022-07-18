<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;
use Carbon\Carbon;

class MedicalStaff extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = [
        'code', 
        'name',
        'gender',
        'phone',
        'email',
        'address',
        'clinic_id',
        'image'
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function clinics()
    {
        return $this->belongsToMany(Clinic::class, MedicalStaffClinic::class);
    }

    public function syncClinics($clinics)
    {
        $this->clinics()->detach();   
        $this->clinics()->attach($clinics);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['clinic']);
    }
}
