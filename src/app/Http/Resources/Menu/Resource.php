<?php

namespace Starmoozie\LaravelAccess\app\Http\Resources\Menu;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Starmoozie\LaravelAccess\app\Http\Resources\Permission\Collection;

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
            'id'          => $this->id,
            'name'        => $this->name,
            'permissions' => new Collection($this->permissions),
        ];
    }
}
