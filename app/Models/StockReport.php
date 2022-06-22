<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class StockReport extends Model
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
    ];
}
