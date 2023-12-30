<?php

namespace Starmoozie\LaravelAccess\app\Http\Requests;

use Illuminate\Validation\Rule;
use Starmoozie\LaravelAccess\app\Models\Role;

class RoleRequest extends BaseRequest
{
    protected $model = Role::class;

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
                'max:' . config('laravel-access.database.columns.roles.name'),
                Rule::unique(Role::class)->when($this->method() === "PUT", fn ($q) => $q->ignore($this->id))
            ]
        ];
    }
}
