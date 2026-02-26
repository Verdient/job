<?php

declare(strict_types=1);

namespace Verdient\Job\Event;

use Verdient\Job\DispatcherInterface;

/**
 * 任务生产开始事件
 *
 * @author Verdient。
 */
class BeforeProduce
{
    /**
     * @param DispatcherInterface $dispatcher 调度器
     *
     * @author Verdient。
     */
    public function __construct(public readonly DispatcherInterface $dispatcher) {}
}
