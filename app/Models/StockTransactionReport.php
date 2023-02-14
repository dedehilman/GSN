<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class StockTransactionReport extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = [
        'code', 
        'file_path', 
        'message', 
        'runned_at', 
        'finished_at', 
        'status', 
        'num_of_downloaded',
        'clinic_id',
        'start_date', 
        'end_date', 
    ];

    public function clinic() {
        return $this->belongsTo(Clinic::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['clinic']);
    }
}
