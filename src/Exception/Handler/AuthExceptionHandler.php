<?php

declare(strict_types=1);
/**
 * This file is part of YxCloud.
 * @link     https://mo.chat
 * @document https://YxCloud.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/YxCloud-cloud/YxCloud/blob/master/LICENSE
 */
namespace YxCloud\Framework\Exception\Handler;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use YxCloud\Framework\Constants\ErrorCode;
use Qbhy\HyperfAuth\Exception\AuthException;
use Qbhy\HyperfAuth\Exception\UnauthorizedException;
use Qbhy\SimpleJwt\Exceptions\InvalidTokenException;
use Qbhy\SimpleJwt\Exceptions\JWTException;
use Qbhy\SimpleJwt\Exceptions\TokenExpiredException;
use Throwable;

class AuthExceptionHandler extends ExceptionHandler
{
    /**
     * @var StdoutLoggerInterface
     */
    protected $logger;

    public function __construct(StdoutLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return mixed
     */
    public function handle(Throwable $throwable, \Psr\Http\Message\ResponseInterface $response)
    {
        $code = ErrorCode::AUTH_FAILED;

        ## 格式化输出
        $throwable instanceof UnauthorizedException && $code                = ErrorCode::AUTH_UNAUTHORIZED;
        $throwable->getPrevious() instanceof TokenExpiredException && $code = ErrorCode::AUTH_SESSION_EXPIRED;
        $throwable->getPrevious() instanceof InvalidTokenException && $code = ErrorCode::AUTH_TOKEN_INVALID;

        $falseMsg = ErrorCode::getMessage($code);
        $httpCode = ErrorCode::getHttpCode($code);

        $data       = responseDataFormat($code, $falseMsg);
        $dataStream = new SwooleStream(json_encode($data, JSON_UNESCAPED_UNICODE));

        ## 阻止异常冒泡
        $this->stopPropagation();
        return $response->withHeader('Server', 'YxCloud')
            ->withAddedHeader('Content-Type', 'application/json;charset=utf-8')
            ->withStatus($httpCode)
            ->withBody($dataStream);
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof AuthException || $throwable instanceof JWTException;
    }
}
