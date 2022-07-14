<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class PharmacyDetail extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['pharmacy_id', 'medicine_id', 'medicine_rule_id', 'stock_qty', 'qty', 'actual_qty'];

    public function medicine() {
        return $this->belongsTo(Medicine::class);
    }

    public function medicineRule() {
        return $this->belongsTo(MedicineRule::class);
    }
    
    public function scopeWithAll($query) 
    {
        return $query->with(['medicine', 'medicineRule']);
    }
}
