<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class Pharmacy extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['transaction_no', 'transaction_date', 'remark', 'clinic_id', 'model_id', 'model_type','status'];

    public function clinic() {
        return $this->belongsTo(Clinic::class);
    }

    public function details()
    {
        return $this->hasMany(PharmacyDetail::class);
    }

    public function referenceTransaction()
    {
        if($this->model_type)
            return $this->model_type::with("patient")->find($this->model_id);
        
        return null;
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['clinic', 'details', 'details.medicine', 'details.medicineRule']);
    }
}
