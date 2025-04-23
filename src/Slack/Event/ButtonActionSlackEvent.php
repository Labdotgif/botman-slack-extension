<?php

declare(strict_types=1);

namespace Labdotgif\Slack\Event;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class ButtonActionSlackEvent extends SlackEvent implements AuthenticatedSlackEventInterface
{
    public const EVENT_NAME = 'slack.button_action';

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
     * @var int
     */
    private $attachmentId;

    /**
     * @var float
     */
    private $messageTimestamp;

    /**
     * @var string
     */
    private $responseUrl;

    /**
     * @var array|null
     */
    private $originalMessage;

    public function __construct(
        string $name,
        string $value,
        string $callbackId,
        string $channelId,
        string $userId,
        int $attachmentId,
        float $messageTimestamp,
        string $responseUrl,
        ?array $originalMessage = null
    ) {
        $this->name             = $name;
        $this->value            = $value;
        $this->callbackId       = $callbackId;
        $this->channelId        = $channelId;
        $this->userId           = $userId;
        $this->attachmentId     = $attachmentId;
        $this->messageTimestamp = $messageTimestamp;
        $this->responseUrl      = $responseUrl;
        $this->originalMessage  = $originalMessage;
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

    public function getAttachmentId(): int
    {
        return $this->attachmentId;
    }

    public function getMessageTimestamp(): float
    {
        return $this->messageTimestamp;
    }

    public function getResponseUrl(): string
    {
        return $this->responseUrl;
    }

    public function getOriginalMessage(): ?array
    {
        return $this->originalMessage;
    }

    public function getEventName(): string
    {
        return static::EVENT_NAME;
    }
}
