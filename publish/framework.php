<?php

declare(strict_types=1);
/**
 * This file is part of YxCloud.
 * @link     https://mo.chat
 * @document https://YxCloud.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/YxCloud-cloud/YxCloud/blob/master/LICENSE
 */
return [
    // YxCloud\Framework\Middleware\JwtAuthMiddleware jwt路由验证白名单
    'auth_white_routes' => [
        '/user/auth', '/weWork/callback',
    ],

    // YxCloud\Framework\Middleware\ResponseMiddleware 原生响应格式的路由
    'response_raw_routes' => [
        '/weWork/callback',
    ],
];