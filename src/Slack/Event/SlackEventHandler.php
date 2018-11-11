<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Event;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class SlackEventHandler
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function handle(string $content): ?Response
    {
        try {
            $event = $this->serializer->deserialize($content, SlackEventInterface::class, 'json');
        } catch (NotNormalizableValueException $e) {
            return null;
        }
    }
}
