<?php

declare(strict_types=1);
/**
 * This file is part of YxCloud.
 * @link     https://mo.chat
 * @document https://YxCloud.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/YxCloud-cloud/YxCloud/blob/master/LICENSE
 */
namespace YxCloud\Framework\Action;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Container\ContainerInterface;

abstract class AbstractAction
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * @Inject
     * @var ResponseInterface
     */
    protected $response;
}
