<?php

namespace Starmoozie\LaravelAccess\app\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MenuPermissionPivot extends Pivot
{
    use HasUuids;

    protected $fillable = [
        "id",
        "menu_id",
        "permission_id"
    ];
}
