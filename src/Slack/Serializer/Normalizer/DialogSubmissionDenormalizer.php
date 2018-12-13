<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Serializer\Normalizer;

use Dividotlab\Slack\Event\DialogSubmissionSlackEvent;
use Dividotlab\Slack\Event\SlackEventInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class DialogSubmissionDenormalizer implements DenormalizerInterface
{
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return new DialogSubmissionSlackEvent(
            $data['channel']['id'],
            $data['user']['id'],
            $data['submission'],
            $data['state'],
            $data['callback_id'],
            $data['response_url']
        );
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return
            SlackEventInterface::class === $type
            && 'json' === $format
            && isset($data['type'])
            && 'dialog_submission' === $data['type']
        ;
    }
}
