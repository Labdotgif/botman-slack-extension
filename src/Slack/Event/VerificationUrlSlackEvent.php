<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Event;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class VerificationUrlSlackEvent extends ResponseAwareSlackEvent
{
    public const EVENT_NAME = 'slack.verification_url';

    /**
     * @var string
     */
    private $slackVerificationToken;

    /**
     * @var string
     */
    private $providedVerificationToken;

    /**
     * @var string
     */
    private $challenge;

    public function __construct(string $slackVerificationToken, string $providedVerificationToken, string $challenge)
    {
        $this->slackVerificationToken    = $slackVerificationToken;
        $this->providedVerificationToken = $providedVerificationToken;
        $this->challenge                 = $challenge;
    }

    public function getSlackVerificationToken(): string
    {
        return $this->slackVerificationToken;
    }

    public function getProvidedVerificationToken(): string
    {
        return $this->providedVerificationToken;
    }

    public function getChallenge(): string
    {
        return $this->challenge;
    }

    public function getEventName(): string
    {
        return static::EVENT_NAME;
    }
}
