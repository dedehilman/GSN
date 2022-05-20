<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class NotificationTemplateNotificationType extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['notification_template_id', 'notification_type'];
}
