<?php

namespace Starmoozie\LaravelAccess\app\Http\Controllers;

use Starmoozie\LaravelAccess\app\Http\Resources\User\{
    Resource,
    Collection
};
use Starmoozie\LaravelAccess\app\Http\Requests\UserRequest as Request;

class UserController extends BaseController
{
    protected $model;
    protected $request    = Request::class;
    protected $resource   = Resource::class;
    protected $collection = Collection::class;
    protected $relations  = ['role'];

    public function __construct()
    {
        $model = config('auth.providers.users.model');

        $this->model = new $model;
    }
}
