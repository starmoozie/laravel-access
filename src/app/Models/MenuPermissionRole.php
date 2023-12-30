<?php

namespace Starmoozie\LaravelAccess\app\Models;

class MenuPermissionRole extends BaseModel
{
    protected $fillable = [
        "id",
        "role_id",
        "menu_permission_id",
    ];
    public $timestamps = false;
}
