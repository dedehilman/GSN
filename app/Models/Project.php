<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class Project extends Model
{
    use HasFactory, BlameableTrait;
    protected $fillable = ['user_id','client_id','project_name','product_id','serial_numbers','location','status'];

    public function user() {
        return $this->HasOne(User::class, 'id', 'user_id');
    }

    public function client() {
        return $this->HasOne(Client::class, 'id', 'client_id');
    }

    public function product() {
        return $this->HasOne(Product::class, 'id', 'product_id');
    }

    public function scopeWithAll($query)
    {
        return $query->with(['user', 'client', 'product']);
    }
}
