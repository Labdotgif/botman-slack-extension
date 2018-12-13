<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Event;

class DialogSubmissionSlackEvent extends SlackEvent
{
    public const EVENT_NAME = 'slack.dialog_submission';

    /**
     * @var string
     */
    private $fromChanneId;

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
        string $fromChanneId,
        string $userId,
        array $submission,
        string $state,
        string $callbackId,
        string $responseUrl
    ) {
        $this->fromChanneId = $fromChanneId;
        $this->userId       = $userId;
        $this->submission   = $submission;
        $this->state        = $state;
        $this->callbackId   = $callbackId;
        $this->responseUrl  = $responseUrl;
    }

    public function getFromChannelId(): string
    {
        return $this->fromChanneId;
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
