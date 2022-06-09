<?php

namespace App\Models;

use App\Traits\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['code', 'name', 'address', 'phone'];

    public function afdelinks()
    {
        return $this->belongsToMany(Afdelink::class, ClinicAfdelink::class);
    }

    public function syncAfdelinks($afdelinks)
    {
        $this->afdelinks()->detach();   
        $this->afdelinks()->attach($afdelinks);
    }
}