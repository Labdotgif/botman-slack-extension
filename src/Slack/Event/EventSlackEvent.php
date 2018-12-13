<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Event;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class EventSlackEvent extends SlackEvent
{
    public const EVENT_NAME = 'slack.event_callback';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $userId;

    public function __construct(string $type, string $userId)
    {
        $this->type   = $type;
        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getEventName(): string
    {
        return static::EVENT_NAME . '.' . $this->type;
    }
}