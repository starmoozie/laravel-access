<?php

namespace Starmoozie\LaravelAccess\app\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Starmoozie\LaravelAccess\app\Enums\HttpCode;
use Starmoozie\LaravelAccess\app\Http\Resources\User\Resource;

class BaseController extends Controller
{
    use \Starmoozie\LaravelAccess\app\Traits\HttpResponse;

    public function forceLogin($request)
    {
        $payload = $request->only(['email', 'password']);

        // Check auth login
        if (!\Auth::validate($payload)) {
            return $this->failedMessage(__('auth.failed'), HttpCode::FAILED_VALIDATION);
        }

        // Auth login
        $entry = \Auth::getProvider()->retrieveByCredentials($payload);

        // Delete old token
        $entry->tokens()->delete();

        // Create new token
        $entry->token = $entry->createToken('token')->accessToken;

        return new Resource($entry);
    }
}
