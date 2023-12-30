<?php

namespace Starmoozie\LaravelAccess\app\Models;

use Laravel\Passport\HasApiTokens as PassportHasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Starmoozie\LaravelAccess\app\Models\Role;

trait User
{
    use PassportHasApiTokens, HasUuids;

    public function __construct()
    {
        parent::__construct();

        $this->incrementing = false;

        $this->fillable = [
            ...$this->fillable,
            ...[
                "id",
                'created_by',
                'role_id'
            ]
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getMenuAttribute()
    {
        $user = \Auth::guard('api')->user();
        $user->load(['role:id,name', 'role.menuPermissions']);

        return $user->role->menus;
    }
}
