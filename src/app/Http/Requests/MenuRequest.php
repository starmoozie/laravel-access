<?php

namespace Starmoozie\LaravelAccess\app\Http\Requests;

use Illuminate\Validation\Rule;
use Starmoozie\LaravelAccess\app\Models\Permission;

class MenuRequest extends BaseRequest
{
    protected $model = Permission::class;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'max:' . config('laravel-access.database.columns.menus.name')
            ],
            'permissions' => [
                'required',
                'array'
            ],
            'permissions.*.id' => [
                'required',
                Rule::exists(Permission::class)
            ]
        ];
    }
}
