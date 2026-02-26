<?php

declare(strict_types=1);

namespace Verdient\Job;

use Override;
use Psr\EventDispatcher\EventDispatcherInterface;
use Verdient\Job\Event\BeforeHandle;
use Verdient\Job\Event\BeforeProduce;
use Verdient\Job\Event\FailedToHandle;
use Verdient\Job\Event\FailedToProduce;
use Verdient\Job\Event\Handled;
use Verdient\Job\Event\Produced;
use Verdient\Task\AbstractTask;
use Verdient\Task\NullEventDispatcher;
use Verdient\Task\Payload;
use Verdient\Task\SafeEventDispatcher;

/**
 * 抽象调度器
 *
 * @author Verdient。
 */
abstract class AbstractDispatcher extends AbstractTask implements DispatcherInterface
{
    /**
     * 事件调度器
     *
     * @author Verdient。
     */
    protected EventDispatcherInterface $eventDispatcher;

    /**
     * @param AdapterInterface 适配器
     *
     * @author Verdient。
     */
    public function __construct(public readonly AdapterInterface $adapter)
    {
        $this->eventDispatcher = new NullEventDispatcher;
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public function setEventDispatcher(?EventDispatcherInterface $eventDispatcher): static
    {
        $this->eventDispatcher = new SafeEventDispatcher($eventDispatcher, $this);

        return $this;
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public function getEventDispatcher(): ?EventDispatcherInterface
    {
        if ($this->eventDispatcher instanceof SafeEventDispatcher) {
            return $this->eventDispatcher->eventDispatcher;
        }

        return null;
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public function idleGap(): int|float
    {
        return $this->adapter->idleGap();
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public function produce(): ?array
    {
        $this->eventDispatcher->dispatch(new BeforeProduce($this));

        $job = null;
        $startAt = microtime(true);
        $endAt = null;

        try {
            $job = $this->adapter->pop($this->queue());
            $endAt = microtime(true);
        } catch (\Throwable $e) {
            if ($endAt === null) {
                $endAt = microtime(true);
            }
            $this->eventDispatcher->dispatch(new FailedToProduce($this, $e, $startAt, $endAt));
            throw $e;
        }

        if ($job) {
            $this->eventDispatcher->dispatch(new Produced($this, $job, $startAt, $endAt));

            return [$job];
        }

        return null;
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public static function consume(Payload $payload): void
    {
        /** @var JobInterface */
        $job = $payload->data[0];

        /** @var DispatcherInterface */
        $dispatcher = $payload->task;

        $dispatcher->eventDispatcher->dispatch(new BeforeHandle($dispatcher, $job));

        $startAt = microtime(true);
        $endAt = null;
        $data = null;

        try {
            $data = $job->handle();
            $endAt = microtime(true);
        } catch (\Throwable $e) {
            if ($endAt === null) {
                $endAt = microtime(true);
            }

            if ($job->retriable($e)) {
                $dispatcher->adapter->retry($job);
            } else {
                $dispatcher->adapter->fault($job, $e);
            }

            $dispatcher->eventDispatcher->dispatch(new FailedToHandle($dispatcher, $job, $e, $startAt, $endAt));

            throw $e;
        }

        $dispatcher->eventDispatcher->dispatch(new Handled($dispatcher, $job, $startAt, $endAt));

        $dispatcher->adapter->commit($job, $data);
    }
}
