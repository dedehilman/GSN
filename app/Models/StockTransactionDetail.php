<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class StockTransactionDetail extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['transaction_id', 'medicine_id', 'qty', 'stock_qty', 'remark'];

    public function medicine() {
        return $this->belongsTo(Medicine::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['medicine']);
    }
}
