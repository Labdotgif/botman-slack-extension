<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Serializer\Normalizer;

use Dividotlab\Slack\Event\EventSlackEvent;
use Dividotlab\Slack\Event\SlackEventInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class EventNormalizer implements DenormalizerInterface
{
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return new EventSlackEvent($data['event']['type'], $data['event']['user']);
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return
            SlackEventInterface::class === $type
            && 'json' === $format
            && isset($data['type'])
            && 'event_callback' === $data['type']
        ;
    }
}
