<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;
use App\Traits\BlameableTrait;

class Role extends SpatieRole
{
    use HasFactory, BlameableTrait;

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($data) {
            $data->menus()->detach();
            $data->permissions()->detach();
            $data->recordRules()->detach();
        });
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, RoleMenu::class);
    }

    public function recordRules()
    {
        return $this->belongsToMany(RecordRule::class, RoleRecordRule::class);
    }

    public function syncMenus($menus)
    {
        $this->menus()->detach();   
        $this->menus()->attach($menus);
    }

    public function syncRecordRules($recordRules)
    {
        $this->recordRules()->detach();   
        $this->recordRules()->attach($recordRules);   
    }
}
