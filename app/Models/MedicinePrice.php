<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class MedicinePrice extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['effective_date', 'medicine_id', 'price'];
}
