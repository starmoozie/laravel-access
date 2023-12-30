<?php

namespace Starmoozie\LaravelAccess\app\Http\Controllers;

use Starmoozie\LaravelAccess\app\Models\Permission as Model;
use Starmoozie\LaravelAccess\app\Http\Resources\Permission\{
    Resource,
    Collection
};
use Starmoozie\LaravelAccess\app\Http\Requests\PermissionRequest as Request;

class PermissionController extends BaseController
{
    protected $model      = Model::class;
    protected $request    = Request::class;
    protected $resource   = Resource::class;
    protected $collection = Collection::class;
}
