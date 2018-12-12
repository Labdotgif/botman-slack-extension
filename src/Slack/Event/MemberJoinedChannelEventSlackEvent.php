<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Event;

class MemberJoinedChannelEventSlackEvent extends EventSlackEvent
{
    /**
     * @var string
     */
    private $channelId;

    public function __construct(string $type, string $userId, string $channelId)
    {
        parent::__construct($type, $userId);

        $this->channelId = $channelId;
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }
}
