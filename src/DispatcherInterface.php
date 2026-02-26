<?php

declare(strict_types=1);

namespace Verdient\Job;

use Psr\EventDispatcher\EventDispatcherInterface;
use Verdient\Task\TaskInterface;

/**
 * 调度器接口
 *
 * @author Verdient。
 */
interface DispatcherInterface extends TaskInterface
{
    /**
     * 获取队列名称
     *
     * @author Verdient。
     */
    public function queue(): string;

    /**
     * 设置事件调度器
     *
     * @author Verdient。
     */
    public function setEventDispatcher(?EventDispatcherInterface $eventDispatcher): static;

    /**
     * 获取事件调度器
     *
     * @author Verdient。
     */
    public function getEventDispatcher(): ?EventDispatcherInterface;
}
