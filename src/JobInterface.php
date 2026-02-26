<?php

declare(strict_types=1);

namespace Verdient\Job;

use Throwable;

/**
 * 任务接口
 *
 * @author Verdient。
 */
interface JobInterface
{
    /**
     * 队列名称
     *
     * @author Verdient。
     */
    public function queue(): string;

    /**
     * 处理程序
     *
     * @author Verdient。
     */
    public function handle(): ?array;

    /**
     * 是否可重试
     *
     * @param Throwable $throwable 异常
     *
     * @author Verdient。
     */
    public function retriable(Throwable $throwable): bool;

    /**
     * 推送任务
     *
     * @author Verdient。
     */
    public function push(): int|string|float|false;
}
