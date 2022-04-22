<?php

declare(strict_types=1);

namespace Labdotgif\Slack\Event;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class SlackEventHandler implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(SerializerInterface $serializer, EventDispatcherInterface $eventDispatcher)
    {
        $this->serializer = $serializer;
        $this->eventDispatcher = $eventDispatcher;

        $this->setLogger(new NullLogger());
    }

    public function handle(string $content): ?Response
    {
        try {
            /** @var SlackEventInterface $event */
            $event = $this->serializer->deserialize($content, SlackEventInterface::class, 'json');
        } catch (NotNormalizableValueException $e) {
            $this->logger->debug('Cannot deserialize content', [
                'content' => $content
            ]);

            return null;
        }

        $this->logger->debug(sprintf('Dispatching Slack event "%s"', $event->getEventName()), [
            'payload' => json_decode($content, true)
        ]);

        $this->eventDispatcher->dispatch($event, $event->getEventName());

        if ($event instanceof ResponseAwareSlackEvent) {
            return $event->getResponse();
        }

        return null;
    }
}
