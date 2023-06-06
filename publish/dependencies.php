<?php

declare(strict_types=1);
/**
 * This file is part of YxCloud.
 * @link     https://mo.chat
 * @document https://YxCloud.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/YxCloud-cloud/YxCloud/blob/master/LICENSE
 */
use Hyperf\Contract\StdoutLoggerInterface;
use YxCloud\Framework\Log\StdoutLoggerFactory;

$dependencies = [];

$appEnv = \Hyperf\Support\env('APP_ENV', 'production');
if ($appEnv !== 'dev') {
    $dependencies[StdoutLoggerInterface::class] = StdoutLoggerFactory::class;
}

return $dependencies + [
];
