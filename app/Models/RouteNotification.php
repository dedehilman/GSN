<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class RouteNotification extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['route_id', 'workflow_trigger', '', 'workflow_recipient', 'notification_template_id'];

    public function route() {
        return $this->belongsTo(Route::class);
    }

    public function notificationTemplate() {
        return $this->belongsTo(NotificationTemplate::class);
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['notificationTemplate']);
    }
}
