<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;
use Carbon\Carbon;

class MedicalStaff extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['code', 'name'];

    public function clinics() {
        return $this->hasMany(MedicalStaffClinic::class)->orderBy('effective_date', 'ASC');
    }

    public function clinic() {
        return $this->hasOne(MedicalStaffClinic::class)->where(function($query)
        {
            $query->whereRaw('? >= effective_date', Carbon::now()->format('Y-m-d'));
            $query->where(function($query) {
                $query->whereNull('expiry_date');
                $query->orWhereRaw('? <= expiry_date', Carbon::now()->format('Y-m-d'));
            });
        })->orderBy('effective_date', 'ASC');
    }

    public function currentClinics() {
        return $this->hasMany(MedicalStaffClinic::class)->where(function($query)
        {
            $query->whereRaw('? >= effective_date', Carbon::now()->format('Y-m-d'));
            $query->where(function($query) {
                $query->whereNull('expiry_date');
                $query->orWhereRaw('? <= expiry_date', Carbon::now()->format('Y-m-d'));
            });
        })->orderBy('effective_date', 'ASC');
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['clinic', 'clinic.clinic']);
    }
}
