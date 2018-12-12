<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Event;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class CommandSlackEvent extends SlackEvent
{
    const EVENT_NAME = 'slack.command';

    /**
     * @var string
     */
    protected $channelId;

    /**
     * @var string
     */
    protected $userId;

    /**
     * @var string
     */
    protected $commandName;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var string
     */
    protected $responseUrl;

    public function __construct(
        string $channelId,
        string $userId,
        string $commandName,
        string $text,
        string $responseUrl
    ) {
        $this->channelId   = $channelId;
        $this->userId      = $userId;
        $this->commandName = $commandName;
        $this->text        = $text;
        $this->responseUrl = $responseUrl;
    }

    public function getEventName(): string
    {
        return static::EVENT_NAME;
    }
}
