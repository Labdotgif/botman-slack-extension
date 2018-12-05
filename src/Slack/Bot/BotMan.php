<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Bot;

use BotMan\BotMan\BotMan as BaseBotMan;

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
}
