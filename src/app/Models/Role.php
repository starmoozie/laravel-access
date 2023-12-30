<?php

namespace Starmoozie\LaravelAccess\app\Models;

class Role extends BaseModel
{
    protected $fillable = [
        "id",
        "name"
    ];

    public function menuPermissions()
    {
        return $this->belongsToMany(MenuPermission::class)
            ->using(MenuPermissionRolePivot::class)
            ->withTimestamps(['id']);
    }

    public function getMenusAttribute()
    {
        return $this->menuPermissions()
            ->leftJoin('menus as m', 'menu_permission.menu_id', 'm.id')
            ->leftJoin('permissions as p', 'menu_permission.permission_id', 'p.id')
            ->select(['m.id as menu_id', 'm.name', 'm.parent_id', 'p.id as permission_id', 'p.name as permission', 'p.key', 'p.method'])
            ->get();
    }
}
