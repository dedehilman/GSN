<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class CompanyGroup extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['code', 'name'];

    public function companies() {
        return $this->hasMany(Company::class);
    }
}
