<?php

namespace Starmoozie\LaravelAccess\app\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RoleMenuPivot extends Pivot
{
    use HasUuids;

    protected $table = 'role_menu';
    protected $fillable = [
        "id",
        "role_id",
        "menu_id",
    ];
}
