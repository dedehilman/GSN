<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class RecordRule extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['name', 'table', 'link', 'rule'];
}
