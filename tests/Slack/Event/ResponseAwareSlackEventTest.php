<?php

declare(strict_types=1);

namespace Labdotgif\Tests\Slack\Event;

use Labdotgif\Slack\Event\ResponseAwareSlackEvent;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class ResponseAwareSlackEventTest extends TestCase
{
    /**
     * @test
     */
    public function setResponse(): void
    {
        $event = $this->createEvent();

        $this->assertAttributeEmpty('response', $event);

        $response = new Response();
        $event->setResponse($response);

        $this->assertAttributeEquals($response, 'response', $event);
    }

    /**
     * @test
     * @depends setResponse
     */
    public function getResponse(): void
    {
        $event = $this->createEvent();

        $this->assertNull($event->getResponse());

        $response = new Response();
        $event->setResponse($response);

        $this->assertEquals($response, $event->getResponse());
    }

    private function createEvent(): ResponseAwareSlackEvent
    {
        return new class extends ResponseAwareSlackEvent {
            public function getEventName(): string
            {
                return 'dummy';
            }
        };
    }
}
