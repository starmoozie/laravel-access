<?php

namespace Starmoozie\LaravelAccess\app\Models;

class Permission extends BaseModel
{
    protected $fillable = [
        "method",
        "name",
        "key",
        "id"
    ];
    public $timestamps = false;
}
