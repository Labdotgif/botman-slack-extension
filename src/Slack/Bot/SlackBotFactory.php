<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Bot;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Slack\SlackDriver;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class SlackBotFactory
{
    public static function create(string $botOAuthToken): BotMan
    {
        DriverManager::loadDriver(SlackDriver::class);

        return BotManFactory::create([
            'slack' => [
                'token' => $botOAuthToken
            ]
        ]);
    }
}
