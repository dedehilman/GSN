<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Traits\BlameableTrait;

class Employee extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = [
        'code', 
        'name', 
        'birth_place',
        'birth_date',
        'gender',
        'identity_number',
        'phone',
        'email',
        'address',
        'join_date',
        'no_bpjs_kesehatan',
        'no_bpjs_ketenagakerjaan',
        'afdelink_id',
        'work_unit_id',
        'grade_id'
    ];

    public function companies() {
        return $this->hasMany(EmployeeCompany::class)->orderBy('effective_date', 'ASC');
    }

    public function company() {
        return $this->hasOne(EmployeeCompany::class)->where(function($query)
        {
            $query->whereRaw('? >= effective_date', Carbon::now()->format('Y-m-d'));
            $query->where(function($query) {
                $query->whereNull('expiry_date');
                $query->orWhereRaw('? <= expiry_date', Carbon::now()->format('Y-m-d'));
            });
        })->orderBy('is_default', 'ASC')
        ->orderBy('effective_date', 'ASC');
    }

    public function currentCompanies() {
        return $this->hasMany(EmployeeCompany::class)->where(function($query)
        {
            $query->whereRaw('? >= effective_date', Carbon::now()->format('Y-m-d'));
            $query->where(function($query) {
                $query->whereNull('expiry_date');
                $query->orWhereRaw('? <= expiry_date', Carbon::now()->format('Y-m-d'));
            });
        })->orderBy('is_default', 'ASC')
        ->orderBy('effective_date', 'ASC');
    }

    public function positions() {
        return $this->hasMany(EmployeePosition::class)->orderBy('effective_date', 'ASC');
    }

    public function position() {
        return $this->hasOne(EmployeePosition::class)->where(function($query)
        {
            $query->whereRaw('? >= effective_date', Carbon::now()->format('Y-m-d'));
            $query->where(function($query) {
                $query->whereNull('expiry_date');
                $query->orWhereRaw('? <= expiry_date', Carbon::now()->format('Y-m-d'));
            });
        })->orderBy('is_default', 'ASC')
        ->orderBy('effective_date', 'ASC');
    }

    public function currentPositions() {
        return $this->hasMany(EmployeePosition::class)->where(function($query)
        {
            $query->whereRaw('? >= effective_date', Carbon::now()->format('Y-m-d'));
            $query->where(function($query) {
                $query->whereNull('expiry_date');
                $query->orWhereRaw('? <= expiry_date', Carbon::now()->format('Y-m-d'));
            });
        })->orderBy('is_default', 'ASC')
        ->orderBy('effective_date', 'ASC');
    }

    public function departments() {
        return $this->hasMany(EmployeeDepartment::class)->orderBy('effective_date', 'ASC');
    }

    public function department() {
        return $this->hasOne(EmployeeDepartment::class)->where(function($query)
        {
            $query->whereRaw('? >= effective_date', Carbon::now()->format('Y-m-d'));
            $query->where(function($query) {
                $query->whereNull('expiry_date');
                $query->orWhereRaw('? <= expiry_date', Carbon::now()->format('Y-m-d'));
            });
        })->orderBy('is_default', 'ASC')
        ->orderBy('effective_date', 'ASC');
    }

    public function currentDepartments() {
        return $this->hasMany(EmployeeDepartment::class)->where(function($query)
        {
            $query->whereRaw('? >= effective_date', Carbon::now()->format('Y-m-d'));
            $query->where(function($query) {
                $query->whereNull('expiry_date');
                $query->orWhereRaw('? <= expiry_date', Carbon::now()->format('Y-m-d'));
            });
        })->orderBy('is_default', 'ASC')
        ->orderBy('effective_date', 'ASC');
    }

    public function attributes() {
        return $this->hasMany(EmployeeAttribute::class)->orderBy('effective_date', 'ASC');
    }

    public function attribute() {
        return $this->hasOne(EmployeeAttribute::class)->where(function($query)
        {
            $query->whereRaw('? >= effective_date', Carbon::now()->format('Y-m-d'));
            $query->where(function($query) {
                $query->whereNull('expiry_date');
                $query->orWhereRaw('? <= expiry_date', Carbon::now()->format('Y-m-d'));
            });
        })->orderBy('is_default', 'ASC')
        ->orderBy('effective_date', 'ASC');
    }

    public function currentAttributes() {
        return $this->hasMany(EmployeeAttribute::class)->where(function($query)
        {
            $query->whereRaw('? >= effective_date', Carbon::now()->format('Y-m-d'));
            $query->where(function($query) {
                $query->whereNull('expiry_date');
                $query->orWhereRaw('? <= expiry_date', Carbon::now()->format('Y-m-d'));
            });
        })->orderBy('is_default', 'ASC')
        ->orderBy('effective_date', 'ASC');
    }

    public function afdelinks() {
        return $this->hasMany(EmployeeAfdelink::class)->orderBy('effective_date', 'ASC');
    }

    public function afdelink() {
        return $this->belongsTo(Afdelink::class);
    }

    public function currentAfdelinks() {
        return $this->hasMany(EmployeeAfdelink::class)->where(function($query)
        {
            $query->whereRaw('? >= effective_date', Carbon::now()->format('Y-m-d'));
            $query->where(function($query) {
                $query->whereNull('expiry_date');
                $query->orWhereRaw('? <= expiry_date', Carbon::now()->format('Y-m-d'));
            });
        })->orderBy('is_default', 'ASC')
        ->orderBy('effective_date', 'ASC');
    }

    public function relationships() {
        return $this->hasMany(EmployeeRelationship::class);
    }

    public function workUnit() {
        return $this->belongsTo(WorkUnit::class);
    }

    public function grade() {
        return $this->belongsTo(Grade::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['afdelink', 'relationships', 'workUnit', 'grade']);
    }
}
