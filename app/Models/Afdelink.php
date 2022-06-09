<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class Afdelink extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['code', 'name', 'estate_id'];

    public function estate() {
        return $this->belongsTo(Estate::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['estate']);
    }
}
