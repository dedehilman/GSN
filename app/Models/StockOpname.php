<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class StockOpname extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['period_id', 'medicine_id', 'clinic_id', 'qty'];

    public function period() {
        return $this->belongsTo(Period::class);
    }

    public function medicine() {
        return $this->belongsTo(Medicine::class);
    }

    public function clinic() {
        return $this->belongsTo(Clinic::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['period', 'medicine','clinic']);
    }
}
