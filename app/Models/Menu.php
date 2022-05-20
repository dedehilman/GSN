<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class Menu extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['code', 'title', 'class', 'nav_header', 'link', 'sequence', 'display', 'parent_id'];
}
