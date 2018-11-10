<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Bot;

use BotMan\BotMan\BotMan;
use PHPUnit\Framework\TestCase;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class SlackBotFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function create(): void
    {
        $this->assertInstanceOf(BotMan::class, SlackBotFactory::create('foo'));
    }
}
