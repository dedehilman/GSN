<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class NodeNotification extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['node_id', 'notification_template_id'];
}
