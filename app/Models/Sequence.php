<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class Sequence extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['name', 'format', 'number_increment', 'number_next', 'use_date_range'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
            $data->sequencePeriods()->delete();
        });
    }

    public function sequencePeriods()
    {
        return $this->hasMany(SequencePeriod::class);
    }

    public function syncSequencePeriods($sequencePeriods)
    {
        $this->sequencePeriods()->delete();
        for ($i=0; $i < count($sequencePeriods); $i++) { 
            $this->sequencePeriods()->save($sequencePeriods[$i]);
        }
    }
}
