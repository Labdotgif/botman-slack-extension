<?php

declare(strict_types=1);

namespace Dividotlab\Tests\Slack\Bot;

use BotMan\BotMan\BotMan;
use Dividotlab\Slack\Bot\BotFactory;
use PHPUnit\Framework\TestCase;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class BotFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function create(): void
    {
        $this->assertInstanceOf(BotMan::class, BotFactory::create('foo'));
    }
}
