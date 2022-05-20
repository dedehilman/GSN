<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class WorkflowParameter extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['workflow_id', 'key', 'value'];
}
