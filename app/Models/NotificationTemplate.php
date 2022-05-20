<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlameableTrait;

class NotificationTemplate extends Model
{
    use HasFactory, BlameableTrait;

    protected $fillable = ['name', 'subject', 'body'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
            $data->notificationTypes()->delete();
        });
    }

    public function notificationTypes() {
        return $this->hasMany(NotificationTemplateNotificationType::class);
    }

    public function syncNotificationTypes($notificationTypes)
    {
        $this->notificationTypes()->delete();   
        for ($i=0; $i < count($notificationTypes); $i++) { 
            $this->notificationTypes()->save($notificationTypes[$i]);
        }
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['notificationTypes']);
    }
}
