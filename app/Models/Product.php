<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class Product extends Model
{
    use HasFactory, BlameableTrait;
    protected $fillable = ['type_id','name', 'stock','merk','display'];

    public function productType() {
        return $this->HasOne(ProductType::class, 'id', 'type_id');
    }

    public function scopeWithAll($query)
    {
        return $query->with('productType');
    }
}
