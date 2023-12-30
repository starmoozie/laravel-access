<?php

namespace Starmoozie\LaravelAccess\app\Http\Controllers;

use Starmoozie\LaravelAccess\app\Models\Role as Model;
use Starmoozie\LaravelAccess\app\Http\Resources\Role\{
    Resource,
    Collection
};
use Starmoozie\LaravelAccess\app\Http\Requests\RoleRequest as Request;

class RoleController extends BaseController
{
    protected $model      = Model::class;
    protected $request    = Request::class;
    protected $resource   = Resource::class;
    protected $collection = Collection::class;
    protected $with       = [];
}
