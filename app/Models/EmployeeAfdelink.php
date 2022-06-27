<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class EmployeeAfdelink extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['employee_id', 'afdelink_id', 'effective_date', 'expiry_date', 'is_default'];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function afdelink() {
        return $this->belongsTo(Afdelink::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['afdelink','employee']);
    }
}
