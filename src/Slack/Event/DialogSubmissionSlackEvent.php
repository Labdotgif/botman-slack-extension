<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Event;

class DialogSubmissionSlackEvent extends ResponseAwareSlackEvent implements AuthenticatedSlackEventInterface
{
    public const EVENT_NAME = 'slack.dialog_submission';

    /**
     * @var string
     */
    private $fromChannelId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var array
     */
    private $submission;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $callbackId;

    /**
     * @var string
     */
    private $responseUrl;

    public function __construct(
        string $fromChannelId,
        string $userId,
        array $submission,
        string $state,
        string $callbackId,
        string $responseUrl
    ) {
        $this->fromChannelId = $fromChannelId;
        $this->userId        = $userId;
        $this->submission    = $submission;
        $this->state         = $state;
        $this->callbackId    = $callbackId;
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

    public function getSubmission(): array
    {
        return $this->submission;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getCallbackId(): string
    {
        return $this->callbackId;
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
