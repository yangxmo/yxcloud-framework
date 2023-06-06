<?php

declare(strict_types=1);
/**
 * This file is part of YxCloud.
 * @link     https://mo.chat
 * @document https://YxCloud.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/YxCloud-cloud/YxCloud/blob/master/LICENSE
 */
namespace YxCloud\Framework\Exception;

use Hyperf\Server\Exception\ServerException;
use YxCloud\Framework\Constants\ErrorCode;

class CommonException extends ServerException
{
    public function __construct(int $code = 0, string $message = null, \Throwable $previous = null)
    {
        if (is_null($message)) {
            $message = ErrorCode::getMessage($code);
            if (! $message && class_exists(\App\Constants\AppErrCode::class)) {
                $message = \App\Constants\AppErrCode::getMessage($code);
            }
        }
        parent::__construct($message, $code, $previous);
    }
}
