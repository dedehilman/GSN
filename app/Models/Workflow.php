<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class Workflow extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['code', 'applicant_id', 'apply_date', 'file', 'workflow_status'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
            $data->workflowDetails()->delete();
            $data->workflowParameters()->delete();
        });
    }

    public function workflowDetails()
    {
        return $this->hasMany(WorkflowDetail::class);
    }

    public function workflowParameters()
    {
        return $this->hasMany(WorkflowParameter::class);
    }

    public function syncWorkflowDetails($workflowDetails)
    {
        $this->workflowDetails()->delete();
        for ($i=0; $i < count($workflowDetails); $i++) { 
            $this->workflowDetails()->save($workflowDetails[$i]);
        }
    }

    public function syncWorkflowParameters($workflowParameters)
    {
        $this->workflowParameters()->delete();
        for ($i=0; $i < count($workflowParameters); $i++) { 
            $this->workflowParameters()->save($workflowParameters[$i]);
        }
    }
}
