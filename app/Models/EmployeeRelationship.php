<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class EmployeeRelationship extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['employee_id', 'relationship_id', 'identity_number', 'name'];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    public function relationship() {
        return $this->belongsTo(Relationship::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['relationship','employee']);
    }
}
