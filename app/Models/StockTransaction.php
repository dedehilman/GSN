<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class StockTransaction extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['transaction_no', 'transaction_date', 'transaction_type', 'reference', 'remark', 'clinic_id', 'new_clinic_id'];

    public function clinic() {
        return $this->belongsTo(Clinic::class);
    }

    public function newClinic() {
        return $this->belongsTo(Clinic::class, 'new_clinic_id');
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['newClinic','clinic']);
    }

    public function details()
    {
        return $this->hasMany(StockTransactionDetail::class);
    }
}
