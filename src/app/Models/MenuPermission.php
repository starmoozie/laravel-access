<?php

namespace Starmoozie\LaravelAccess\app\Models;

class MenuPermission extends BaseModel
{
    protected $table    = 'menu_permission';
    protected $fillable = [
        "id",
        "menu_id",
        "permission_id"
    ];
    public $timestamps = false;
}
