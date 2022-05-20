<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class WorkflowDetail extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['workflow_id', 'sequence', 'node_type', 'node_owner_type', 'executor_id', 'executed_date', 'remark', 'workflow_status'];
}
