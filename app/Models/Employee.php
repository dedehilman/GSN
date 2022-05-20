<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Traits\BlameableTrait;

class Employee extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['code', 'name', 'user_id'];

    public function companies() {
        return $this->hasMany(EmployeeCompany::class);
    }

    public function company() {
        return $this->hasOne(EmployeeCompany::class)->where(function($query)
        {
            $query->whereRaw('? >= effective_date', Carbon::now()->format('Y-m-d'));
            $query->where(function($query) {
                $query->whereNull('expiry_date');
                $query->orWhereRaw('? <= expiry_date', Carbon::now()->format('Y-m-d'));
            });
        })->orderBy('is_default', 'ASC');
    }

    public function currentCompanies() {
        return $this->hasMany(EmployeeCompany::class)->where(function($query)
        {
            $query->whereRaw('? >= effective_date', Carbon::now()->format('Y-m-d'));
            $query->where(function($query) {
                $query->whereNull('expiry_date');
                $query->orWhereRaw('? <= expiry_date', Carbon::now()->format('Y-m-d'));
            });
        })->orderBy('is_default', 'ASC');
    }

    public function positions() {
        return $this->hasMany(EmployeePosition::class);
    }

    public function position() {
        return $this->hasOne(EmployeePosition::class)->where(function($query)
        {
            $query->whereRaw('? >= effective_date', Carbon::now()->format('Y-m-d'));
            $query->where(function($query) {
                $query->whereNull('expiry_date');
                $query->orWhereRaw('? <= expiry_date', Carbon::now()->format('Y-m-d'));
            });
        })->orderBy('is_default', 'ASC');
    }

    public function currentPositions() {
        return $this->hasMany(EmployeePosition::class)->where(function($query)
        {
            $query->whereRaw('? >= effective_date', Carbon::now()->format('Y-m-d'));
            $query->where(function($query) {
                $query->whereNull('expiry_date');
                $query->orWhereRaw('? <= expiry_date', Carbon::now()->format('Y-m-d'));
            });
        })->orderBy('is_default', 'ASC');
    }

    public function departments() {
        return $this->hasMany(EmployeeDepartment::class);
    }

    public function department() {
        return $this->hasOne(EmployeeDepartment::class)->where(function($query)
        {
            $query->whereRaw('? >= effective_date', Carbon::now()->format('Y-m-d'));
            $query->where(function($query) {
                $query->whereNull('expiry_date');
                $query->orWhereRaw('? <= expiry_date', Carbon::now()->format('Y-m-d'));
            });
        })->orderBy('is_default', 'ASC');
    }

    public function currentDepartments() {
        return $this->hasMany(EmployeeDepartment::class)->where(function($query)
        {
            $query->whereRaw('? >= effective_date', Carbon::now()->format('Y-m-d'));
            $query->where(function($query) {
                $query->whereNull('expiry_date');
                $query->orWhereRaw('? <= expiry_date', Carbon::now()->format('Y-m-d'));
            });
        })->orderBy('is_default', 'ASC');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['user', 'department', 'department.department', 'position', 'position.position', 'company', 'company.company']);
    }
}
