<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Serializer\Normalizer;

use Dividotlab\Slack\Event\ButtonActionSlackEvent;
use Dividotlab\Slack\Event\SlackEventInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class ButtonActionDenormalizer implements DenormalizerInterface
{
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return new ButtonActionSlackEvent(
            $data['actions'][0]['name'],
            $data['actions'][0]['value'],
            $data['callback_id'],
            $data['channel']['id'],
            $data['user']['id'],
            (int) $data['attachment_id'],
            (float) $data['message_ts'],
            $data['response_url'],
            $data['original_message'] ?? null
        );
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return
            SlackEventInterface::class === $type
            && 'json' === $format
            && isset($data['type'])
            && 'interactive_message' === $data['type']
            && isset($data['actions'][0]['type'])
            && 'button' === $data['actions'][0]['type']
        ;
    }
}
