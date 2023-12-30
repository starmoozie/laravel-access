<?php

namespace Starmoozie\LaravelAccess\app\Http\Controllers;

class BaseController extends Controller
{
    use Operations\DeleteOperation;
    use Operations\IndexOperation;
    use Operations\ShowOperation;
    use Operations\StoreOperation;
    use Operations\UpdateOperation;

    protected $model;
    protected $request;
    protected $resource;
    protected $collection;
    protected $relations  = [];

    public function __construct()
    {
        $this->model = (new $this->model);
    }
}
