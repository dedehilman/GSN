<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class Estate extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['code', 'name', 'company_id'];

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['company']);
    }
}
