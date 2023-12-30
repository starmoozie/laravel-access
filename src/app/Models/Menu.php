<?php

namespace Starmoozie\LaravelAccess\app\Models;

class Menu extends BaseModel
{
    protected $fillable = [
        "id",
        "name"
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)
            ->using(MenuPermissionPivot::class)
            ->withPivot(['id']);
    }
}
