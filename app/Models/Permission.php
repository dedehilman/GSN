<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission as SpatiePermission;
use App\Traits\BlameableTrait;

class Permission extends SpatiePermission
{
    use HasFactory, BlameableTrait;
}
