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

use ErrorException;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use YxCloud\Framework\Constants\ErrorCode;
use Throwable;

class ErrorExceptionHandler extends ExceptionHandler
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
        ## 记录日志
        $this->logger->error(sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
        $this->logger->error($throwable->getTraceAsString());

        ## 格式化输出
        $level      = $throwable instanceof ErrorException ? 'error' : 'hard';
        $data       = responseDataFormat(ErrorCode::SERVER_ERROR, '后台服务异常.' . $level);
        $dataStream = new SwooleStream(json_encode($data, JSON_UNESCAPED_UNICODE));

        ## 阻止异常冒泡
        $this->stopPropagation();
        return $response->withHeader('Server', 'YxCloud')
            ->withAddedHeader('Content-Type', 'application/json;charset=utf-8')
            ->withStatus(ErrorCode::getHttpCode(ErrorCode::SERVER_ERROR))
            ->withBody($dataStream);
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
