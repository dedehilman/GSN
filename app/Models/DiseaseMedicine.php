<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class DiseaseMedicine extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['disease_id', 'medicine_id', 'medicine_rule_id', 'qty'];
}