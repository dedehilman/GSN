<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Afdelink extends Model
{
    use HasFactory, BlameableTrait, LogsActivity;

    protected $fillable = ['code', 'name', 'estate_id'];
    protected static $logFillable = true;

    public function estate() {
        return $this->belongsTo(Estate::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['estate']);
    }
}
