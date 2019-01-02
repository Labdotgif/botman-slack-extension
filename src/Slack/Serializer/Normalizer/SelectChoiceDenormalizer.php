<?php

declare(strict_types=1);

namespace Labdotgif\Slack\Serializer\Normalizer;

use Labdotgif\Slack\Event\SelectChoiceSlackEvent;
use Labdotgif\Slack\Event\SlackEventInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class SelectChoiceDenormalizer implements DenormalizerInterface
{
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return new SelectChoiceSlackEvent(
            $data['actions'][0]['name'],
            $data['actions'][0]['selected_options'][0]['value'],
            $data['callback_id'],
            $data['channel']['id'],
            $data['user']['id'],
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
            && 'select' === $data['actions'][0]['type']
        ;
    }
}
