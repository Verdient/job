<?php

declare(strict_types=1);

namespace Verdient\Job;

use Throwable;
use Verdient\Job\JobInterface;

/**
 * 适配器接口
 *
 * @author Verdient。
 */
interface AdapterInterface
{
    /**
     * 获取空闲间隔
     *
     * @author Verdient。
     */
    public function idleGap(): int|float;

    /**
     * 推送任务
     *
     * @param JobInterface $job 待推送的任务
     *
     * @author Verdient。
     */
    public function push(JobInterface $job): int|string|float|false;

    /**
     * 弹出任务
     *
     * @param string $queue 队列名称
     *
     * @author Verdient。
     */
    public function pop(string $queue): ?JobInterface;

    /**
     * 提交任务
     *
     * @param JobInterface $job 待提交的任务
     * @param ?array $data 数据
     *
     * @author Verdient。
     */
    public function commit(JobInterface $job, ?array $data): void;

    /**
     * 故障
     *
     * @param JobInterface $job 待提交的任务
     * @param Throwable $throwable 异常
     *
     * @author Verdient。
     */
    public function fault(JobInterface $job, Throwable $throwable): void;

    /**
     * 重试任务
     *
     * @param JobInterface $job 任务
     *
     * @author Verdient。
     */
    public function retry(JobInterface $job): void;
}
