<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Serializer\Normalizer;

use Dividotlab\Slack\Event\MemberJoinedChannelEventSlackEvent;
use Dividotlab\Slack\Event\SlackEvents;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class MemberJoinedChannelEventDenormalizer extends EventDenormalizer
{
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        return new MemberJoinedChannelEventSlackEvent(
            $data['event']['type'],
            $data['event']['user'],
            $data['event']['channel']
        );
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        if (!parent::supportsDenormalization($data, $type, $format)) {
            return false;
        }

        return SlackEvents::MEMBER_JOINED_CHANNEL === $data['event']['type'];
    }
}
