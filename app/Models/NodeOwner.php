<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class NodeOwner extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['node_id', 'owner_id'];
}
