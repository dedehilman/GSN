<?php

namespace App\Models;

use App\Traits\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiseaseGroup extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['code', 'name'];
}
