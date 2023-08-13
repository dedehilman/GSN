<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['fullname', 'email','phone','address'];

    protected $casts = ['created_at' => 'datetime', 'updated_at' => 'datetime'];
}
