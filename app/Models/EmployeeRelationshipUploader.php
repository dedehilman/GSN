<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class EmployeeRelationshipUploader extends Model
{
    use HasFactory, BlameableTrait;
}
