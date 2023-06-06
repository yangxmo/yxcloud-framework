<?php

declare(strict_types=1);
/**
 * This file is part of YxCloud.
 * @link     https://mo.chat
 * @document https://YxCloud.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/YxCloud-cloud/YxCloud/blob/master/LICENSE
 */
namespace YxCloud\Framework\Service;

abstract class AbstractService
{
    /**
     * @var \Hyperf\Database\Model\Model
     */
    protected $model;

    public function __construct()
    {
        $modelClass  = str_replace(['\Service', 'Service'], ['\Model', ''], get_class($this));
        $this->model = make($modelClass);
    }
}
