<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class Position extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['code', 'name'];
}