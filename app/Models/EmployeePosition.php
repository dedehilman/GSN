<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class EmployeePosition extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['employee_id', 'position_id', 'effective_date', 'expiry_date', 'is_default'];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function position() {
        return $this->belongsTo(Position::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['position','employee']);
    }
}
