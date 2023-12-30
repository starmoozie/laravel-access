<?php

namespace Starmoozie\LaravelAccess\app\Traits;

use Starmoozie\LaravelAccess\app\Enums\HttpCode;

trait HttpResponse
{
    public function successMessage($data = null, $message = null, $code = HttpCode::SUCCESS)
    {
        return response()->json([
            'success' => true,
            'message' => $message ?? __("message.success"),
            'data'    => $data
        ], $code);
    }

    public function failedMessage($message = null, $code = HttpCode::FAILED)
    {
        return response()->json([
            'success' => false,
            'message' => $message ?? __("message.failed"),
            'data'    => null
        ], $code);
    }

    public function translationMessage($method)
    {
        return __("laravel-access-trans::message.success_{$method}", ["attribute" => request()->segment(1)]);
    }
}
