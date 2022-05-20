<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class Department extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['code', 'name', 'parent_id'];

    public function parent() {
        return $this->belongsTo(Department::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['parent']);
    }
}
