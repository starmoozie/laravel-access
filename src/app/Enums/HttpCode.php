<?php

namespace Starmoozie\LaravelAccess\app\Enums;

final class HttpCode
{
    const SUCCESS = 200;
    const CREATED = 201;
    const NO_CONTENT = 204;
    const FAILED  = 400;
    const UNAUTHENTICATED = 401;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const FAILED_VALIDATION = 422;
}
