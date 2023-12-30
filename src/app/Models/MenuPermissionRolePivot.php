<?php

namespace Starmoozie\LaravelAccess\app\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MenuPermissionRolePivot extends Pivot
{
    use HasUuids;

    protected $fillable = [
        "id",
        "role_id",
        "menu_permission_id",
    ];
}
