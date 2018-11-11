<?php

declare(strict_types=1);

namespace Dividotlab\Tests\Slack\Event;

use Dividotlab\Slack\Event\SlackEventInterface;
use Dividotlab\Slack\Event\VerificationUrlSlackEvent;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class VerificationUrlSlackEventTest extends SlackEventTestCase
{
    /**
     * @test
     */
    public function getSlackVerificationToken(): void
    {
        $this->assertEquals('foo', $this->createEvent()->getSlackVerificationToken());
    }

    /**
     * @test
     */
    public function getProvidedVerificationToken(): void
    {
        $this->assertEquals('bar', $this->createEvent()->getProvidedVerificationToken());
    }

    /**
     * @test
     */
    public function getChallenge(): void
    {
        $this->assertEquals('baz', $this->createEvent()->getChallenge());
    }

    protected function getSlackEvent(): SlackEventInterface
    {
        return $this->createEvent();
    }

    private function createEvent(
        string $slackVerificationUrl = 'foo',
        string $providedVerificationToken = 'bar',
        string $challenge = 'baz'
    ): VerificationUrlSlackEvent {
        return new VerificationUrlSlackEvent($slackVerificationUrl, $providedVerificationToken, $challenge);
    }
}
