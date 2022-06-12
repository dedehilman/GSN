<?php

namespace App\Models;

use App\Traits\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiseaseMedicine extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['disease_id', 'medicine_id', 'medicine_rule_id', 'qty'];

    public function disease() {
        return $this->belongsTo(Disease::class);
    }

    public function medicine() {
        return $this->belongsTo(Medicine::class);
    }

    public function medicineRule() {
        return $this->belongsTo(MedicineRule::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['disease', 'medicine','medicineRule']);
    }
}
