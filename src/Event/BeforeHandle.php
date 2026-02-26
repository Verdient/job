<?php

declare(strict_types=1);

namespace Verdient\Job\Event;

use Verdient\Job\DispatcherInterface;
use Verdient\Job\JobInterface;

/**
 * 任务处理开始事件
 *
 * @author Verdient。
 */
class BeforeHandle
{
    /**
     * @param DispatcherInterface $dispatcher 调度器
     * @param JobInterface $job 任务
     *
     * @author Verdient。
     */
    public function __construct(
        public readonly DispatcherInterface $dispatcher,
        public readonly JobInterface $job
    ) {}
}
