<?php

namespace Starmoozie\LaravelAccess\app\Http\Requests;

use Illuminate\Validation\Rule;
use Starmoozie\LaravelAccess\app\Models\Permission;

class PermissionRequest extends BaseRequest
{
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
                'max:' . config('laravel-access.database.columns.permissions.name'),
            ],
            'method' => [
                'required',
                'max:' . config('laravel-access.database.columns.permissions.method'),
            ],
            'key' => [
                'required',
                'max:' . config('laravel-access.database.columns.permissions.key'),
                Rule::unique(Permission::class)->when($this->method() === "PUT", fn ($q) => $q->ignore($this->id))
            ]
        ];
    }
}
