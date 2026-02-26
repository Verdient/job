<?php

declare(strict_types=1);

namespace Verdient\Job\Event;

use Throwable;
use Verdient\Job\DispatcherInterface;
use Verdient\Job\JobInterface;

/**
 * 任务处理失败事件
 *
 * @author Verdient。
 */
class FailedToHandle
{
    /**
     * @param DispatcherInterface $dispatcher 调度器
     * @param JobInterface $job 任务
     * @param Throwable $throwable 异常对象
     * @param float $startAt 开始时间
     * @param float $endAt 结束时间
     *
     * @author Verdient。
     */
    public function __construct(
        public readonly DispatcherInterface $dispatcher,
        public readonly JobInterface $job,
        public readonly Throwable $throwable,
        public readonly float $startAt,
        public readonly float $endAt
    ) {}
}
