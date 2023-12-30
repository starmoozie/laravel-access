<?php

namespace Starmoozie\LaravelAccess\app\Http\Controllers\Auth;

use Starmoozie\LaravelAccess\app\Http\Requests\Auth\LoginRequest as Request;

class LoginController extends BaseController
{
    public function login(Request $request)
    {
        return $this->forceLogin($request);
    }
}
