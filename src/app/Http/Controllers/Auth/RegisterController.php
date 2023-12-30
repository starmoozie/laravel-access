<?php

namespace Starmoozie\LaravelAccess\app\Http\Controllers\Auth;

use Starmoozie\LaravelAccess\app\Http\Requests\Auth\RegisterRequest as Request;

class RegisterController extends BaseController
{
    public function register(Request $request)
    {
        // User::create(
        //     $request->only((new User)->getFillable())
        // );

        // $request->merge(['password' => $request->password_confirmation]);

        // return $this->forceLogin($request);
    }
}
