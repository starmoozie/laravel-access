<?php

namespace Starmoozie\LaravelAccess\app\Http\Resources\Role;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Starmoozie\LaravelAccess\app\Http\Resources\Menu\Collection as MenuCollection;

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
            'menus' => $request->route()->getName() === "profile" ? $this->mappingMenus($this->menus) : [],
        ];
    }

    protected function mappingMenus($menus)
    {
        $data = [];
        foreach ($menus->groupBy(['menu_id', 'name']) as $key => $menu) {
            $data[] = [
                'id'          => $key,
                'name'        => $menu->keys()->first(),
                'permissions' => $this->mappingPermissions($menu->flatten())
            ];
        }

        return $data;
    }

    protected function mappingPermissions($menus)
    {
        return $menus->map(fn ($q) => [
            'id'     => $q->permission_id,
            'name'   => $q->permission,
            'key'    => $q->key,
            'method' => $q->method,
        ]);
    }
}
