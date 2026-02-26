<?php

declare(strict_types=1);

namespace Verdient\Job;

use Override;
use Throwable;

/**
 * 抽象任务
 *
 * @author Verdient。
 */
abstract class AbstractJob implements JobInterface
{
    /**
     * @author Verdient。
     */
    #[Override]
    public function queue(): string
    {
        return 'default';
    }

    /**
     * @author Verdient。
     */
    #[Override]
    public function retriable(Throwable $throwable): bool
    {
        return false;
    }
}
