<?php

declare(strict_types=1);

namespace Labdotgif\Slack\Event;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
interface SlackEventInterface
{
    /**
     * @return string
     */
    public function getEventName(): string;
}
