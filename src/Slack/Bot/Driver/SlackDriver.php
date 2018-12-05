<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Bot\Driver;

use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\Drivers\Slack\SlackDriver as BaseSlackDriver;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class SlackDriver extends BaseSlackDriver
{
    private const RESULT_EPHEMERAL = 'ephemeral';

    public function buildServicePayload($message, $matchingMessage, $additionalParameters = [])
    {
        if (
            isset($additionalParameters['extra']['ephemeral'])
            && true === $additionalParameters['extra']['ephemeral']
        ) {
            $this->resultType = static::RESULT_EPHEMERAL;
            $payload = $this->respondJSONWithToken($message, $matchingMessage, $additionalParameters);
        } else {
            $payload = parent::buildServicePayload($message, $matchingMessage, $additionalParameters);
        }

        if (isset($additionalParameters['extra'])) {
            unset($payload['extra']);
        }

        return $payload;
    }

    public function sendPayload($payload)
    {
        if (static::RESULT_EPHEMERAL === $this->resultType) {
            return $this->http->get('https://slack.com/api/chat.postEphemeral', $payload);
        }

        return parent::sendPayload($payload);
    }

    protected function respondJSONWithToken(string $message, IncomingMessage $matchingMessage, $parameters = []): array
    {
        $payload = parent::respondJSON($message, $matchingMessage, $parameters);
        $payload['token'] = $this->config->get('token');

        return $payload;
    }
}
