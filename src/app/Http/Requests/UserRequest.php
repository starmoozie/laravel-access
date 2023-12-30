<?php

namespace Starmoozie\LaravelAccess\app\Http\Requests;

use Illuminate\Validation\Rule;
use Starmoozie\LaravelAccess\app\Models\Role;

class UserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $model = config('auth.providers.users.model');

        return [
            'name' => [
                'required',
                'max:' . config('laravel-access.database.columns.users.name')
            ],
            'email' => [
                'required',
                'max:' . config('laravel-access.database.columns.users.email'),
                Rule::unique((new $model)->getTable())->when($this->method() === "PUT", fn ($q) => $q->ignore($this->id))
            ],
            'password' => [
                'required',
                'confirmed'
            ],
            'role_id' => [
                'required',
                Rule::exists(Role::class, 'id')
            ],
            'created_by' => [
                'required'
            ]
        ];
    }

    public function prepareForValidation()
    {
        $this->merge(['created_by' => \Auth::user()->id]);
    }

    public function passedValidation()
    {
        $this->merge(['password' => \Hash::make($this->password)]);
    }
}
