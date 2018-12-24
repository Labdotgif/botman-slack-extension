<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Event;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class SelectChoiceSlackEvent extends SlackEvent
{
    public const EVENT_NAME = 'slack.select_choice';

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $callbackId;

    /**
     * @var string
     */
    private $channelId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var array
     */
    private $originalMessage;

    /**
     * @var string
     */
    private $responseUrl;

    public function __construct(
        string $name,
        string $value,
        string $callbackId,
        string $channelId,
        string $userId,
        array $originalMessage,
        string $responseUrl
    ) {
        $this->name            = $name;
        $this->value           = $value;
        $this->callbackId      = $callbackId;
        $this->channelId       = $channelId;
        $this->userId          = $userId;
        $this->originalMessage = $originalMessage;
        $this->responseUrl     = $responseUrl;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getCallbackId(): string
    {
        return $this->callbackId;
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getOriginalMessage(): array
    {
        return $this->originalMessage;
    }

    public function getResponseUrl(): string
    {
        return $this->responseUrl;
    }

    public function getEventName(): string
    {
        return static::EVENT_NAME;
    }
}
