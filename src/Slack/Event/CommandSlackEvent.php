<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Event;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class CommandSlackEvent extends SlackEvent implements AuthenticatedSlackEventInterface
{
    public const EVENT_NAME = 'slack.command';

    /**
     * @var string
     */
    protected $fromChannelId;

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
        string $fromChannelId,
        string $userId,
        string $commandName,
        string $text,
        string $responseUrl
    ) {
        $this->fromChannelId = $fromChannelId;
        $this->userId        = $userId;
        $this->commandName   = mb_substr($commandName, 1); // Removing first slash
        $this->text          = $text;
        $this->responseUrl   = $responseUrl;
    }

    public function getFromChannelId(): string
    {
        return $this->fromChannelId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getCommandName(): string
    {
        return $this->commandName;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getEventName(): string
    {
        return static::EVENT_NAME;
    }
}
