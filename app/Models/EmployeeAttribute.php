<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class EmployeeAttribute extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['employee_id', 'attribute_id', 'effective_date', 'expiry_date', 'is_default'];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function attribute() {
        return $this->belongsTo(Attribute::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['attribute','employee']);
    }
}
