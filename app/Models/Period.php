<?php

namespace App\Models;

use App\Traits\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['code', 'name', 'start_date', 'end_date', 'closed_date', 'clinic_id'];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['clinic']);
    }
}
