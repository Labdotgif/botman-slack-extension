<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Serializer\Normalizer;

use Dividotlab\Slack\Event\SlackEventInterface;
use Dividotlab\Slack\Event\VerificationUrlSlackEvent;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class VerificationUrlNormalizer implements DenormalizerInterface
{
    /**
     * @var string
     */
    private $slackVerificationToken;

    public function __construct(string $slackVerificationToken)
    {
        $this->slackVerificationToken = $slackVerificationToken;
    }

    public function denormalize($data, $class, $format = null, array $context = array())
    {
        return new VerificationUrlSlackEvent(
            $this->slackVerificationToken,
            $data['token'],
            $data['challenge']
        );
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return
            SlackEventInterface::class === $type
            && 'json' === $format
            && isset($data['type'])
            && 'url_verification' === $data['type']
        ;
    }
}
