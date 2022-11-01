<?php

declare(strict_types=1);

namespace Labdotgif\Slack\Bot\Driver;

use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\Drivers\Slack\Extensions\User;
use BotMan\Drivers\Slack\SlackDriver as BaseSlackDriver;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class SlackDriver extends BaseSlackDriver
{
    protected const RESULT_EPHEMERAL = 'ephemeral';

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

    public function post(
        string $url,
        array $payload,
        array $urlParameters = [],
        array $headers = [],
        $asJSON = true
    ) {
        return $this->http->post($url, $urlParameters, $payload, $headers, $asJSON);
    }

    protected function respondJSONWithToken($message, IncomingMessage $matchingMessage, $parameters = []): array
    {
        $payload = parent::respondJSON($message, $matchingMessage, $parameters);

        if (static::RESULT_EPHEMERAL === $this->resultType) {
            $payload['token'] = $this->config->get('oauth.token');
        }

        return $payload;
    }

    public function getUser(IncomingMessage $matchingMessage)
    {
        $response = $this->sendRequest('users.info', [
            'user'           => $matchingMessage->getSender(),
            'include_locale' => 1
        ], $matchingMessage);
        try {
            $content = json_decode($response->getContent(), true);

            return new User(null, $content['user']);
        } catch (\Exception $e) {
            return new User(null, [
                'id' => $matchingMessage->getSender()
            ]);
        }
    }
}
