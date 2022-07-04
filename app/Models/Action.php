<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class Action extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['action', 'remark', 'reference_type', 'reference_id', 'reference_clinic_id','remedicate_date'];

    public function reference() {
        return $this->belongsTo(Reference::class);
    }

    public function referenceClinic() {
        return $this->belongsTo(Clinic::class, 'reference_clinic_id');
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['reference', 'referenceClinic']);
    }
}