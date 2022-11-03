<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class Pharmacy extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['transaction_no', 'transaction_date', 'remark', 'clinic_id', 'model_id', 'model_type'];

    public function clinic() {
        return $this->belongsTo(Clinic::class);
    }

    public function details()
    {
        return $this->hasMany(PharmacyDetail::class);
    }

    public function referenceTransaction()
    {
        return $this->model_type::find($this->model_id);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['clinic', 'details', 'details.medicine', 'details.medicineRule']);
    }
}
