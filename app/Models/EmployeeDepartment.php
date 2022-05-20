<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class EmployeeDepartment extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['employee_id', 'department_id', 'effective_date', 'expiry_date', 'is_default'];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['department','employee']);
    }
}
