<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\BlameableTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, BlameableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        // 'phone',
        'password',
        'enabled',
        'user_detail_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function appearance()
    {
        return $this->hasOne(AppearanceSetting::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
            $data->roles()->detach();
        });
    }

    public function scopeWithAll($query) 
    {
        return $query->with(['roles', 'userDetail', 'userDetail.clinic', 'roles.recordRules', 'roles.permissions']);
    }

    public function userDetail()
    {
        return $this->belongsTo(MedicalStaff::class, 'user_detail_id');
    }
}
