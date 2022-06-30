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
        'address'
    ];

    public function clinics()
    {
        return $this->belongsToMany(Clinic::class, MedicalStaffClinic::class);
    }

    public function syncClinics($clinics)
    {
        $this->clinics()->detach();   
        $this->clinics()->attach($clinics);
    }
}
