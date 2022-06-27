<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class Reference extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['code', 'name', 'reference_type_id'];


    public function referenceType() {
        return $this->belongsTo(ReferenceType::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['referenceType']);
    }
}
