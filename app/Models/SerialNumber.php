<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerialNumber extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'number', 'status'];

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

}