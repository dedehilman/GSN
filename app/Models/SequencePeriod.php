<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class SequencePeriod extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['effective_date', 'expiry_date', 'number_next', 'sequence_id'];

    public function sequence() {
        return $this->belongsTo(Sequence::class);
    }
}
