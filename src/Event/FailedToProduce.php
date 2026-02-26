<?php

declare(strict_types=1);

namespace Verdient\Job\Event;

use Throwable;
use Verdient\Job\DispatcherInterface;

/**
 * 任务生产失败事件
 *
 * @author Verdient。
 */
class FailedToProduce
{
    /**
     * @param DispatcherInterface $dispatcher 调度器
     * @param Throwable $throwable 异常对象
     * @param float $startAt 开始时间
     * @param float $endAt 结束时间
     *
     * @author Verdient。
     */
    public function __construct(
        public readonly DispatcherInterface $dispatcher,
        public readonly Throwable $throwable,
        public readonly float $startAt,
        public readonly float $endAt
    ) {}
}
