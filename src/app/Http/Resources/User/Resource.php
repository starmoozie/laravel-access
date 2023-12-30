<?php

namespace Starmoozie\LaravelAccess\app\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Starmoozie\LaravelAccess\app\Http\Resources\Role\Resource as RoleResource;

class Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
            'token' => \in_array($request->route()->getName(), config('laravel-access.auth_route')) ? $this->token : null,
            'role'  => new RoleResource($this->role)
        ];
    }
}
