<?php

declare(strict_types=1);

namespace Labdotgif\Slack\Event;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
interface AuthenticatedSlackEventInterface
{
    /**
     * @return string
     */
    public function getUserId(): string;
}
