<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class Company extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['code', 'name', 'company_group_id'];

    public function companyGroup() {
        return $this->belongsTo(CompanyGroup::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['companyGroup']);
    }
}
