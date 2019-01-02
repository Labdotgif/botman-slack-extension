<?php

declare(strict_types=1);

namespace Labdotgif\Tests\Slack\Event;

use Labdotgif\Slack\Event\SlackEventInterface;
use PHPUnit\Framework\TestCase;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
abstract class SlackEventTestCase extends TestCase
{
    /**
     * @test
     */
    public function getEventName(): void
    {
        $this->assertNotNull($this->getSlackEvent()->getEventName());
        $this->assertInternalType('string', $this->getSlackEvent()->getEventName());
    }

    abstract protected function getSlackEvent(): SlackEventInterface;
}
