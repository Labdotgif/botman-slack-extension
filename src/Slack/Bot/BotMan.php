<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Bot;

use BotMan\BotMan\BotMan as BaseBotMan;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Interfaces\DriverInterface;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\Drivers\Slack\Extensions\Dialog;
use BotMan\Drivers\Slack\SlackDriver;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class BotMan extends BaseBotMan
{
    public function sayEphemeral(
        string $message,
        string $userId,
        string $channelId,
        string $driver = null,
        array $additionalParameters = []
    ) {
        $additionalParameters = array_merge_recursive($additionalParameters, [
            'user'    => $userId,
            'channel' => $channelId,
            'extra'   => [
                'ephemeral' => true
            ]
        ]);

        $data = $this->say($message, $userId, $driver, $additionalParameters);

        return $data;
    }

    public function dialog(string $userId, Dialog $dialog, array $additionalParameters = [], $driver = null)
    {
        if ($driver instanceof DriverInterface) {
            $this->setDriver($driver);
        } elseif (\is_string($driver)) {
            $this->setDriver(DriverManager::loadFromName($driver, $this->config));
        }

        if (!$this->getDriver() instanceof SlackDriver) {
            throw new \InvalidArgumentException('Dialog is only implemented with Slack HTTP driver');
        }

        /** @var SlackDriver $driver */
        $driver = $this->getDriver();

        return $driver->replyDialog($dialog, $additionalParameters, new IncomingMessage('', $userId, ''), $this);
    }
}
