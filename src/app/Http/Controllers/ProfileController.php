<?php

namespace Starmoozie\LaravelAccess\app\Http\Controllers;

use Starmoozie\LaravelAccess\app\Http\Resources\User\Resource;

final class ProfileController extends Controller
{
    public function show()
    {
        return $this->successMessage(
            new Resource(\Auth::user()),
            $this->translationMessage(__FUNCTION__)
        );
    }
}
