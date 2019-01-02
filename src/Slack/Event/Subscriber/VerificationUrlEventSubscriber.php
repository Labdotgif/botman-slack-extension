<?php

declare(strict_types=1);

namespace Labdotgif\Slack\Event\Subscriber;

use Labdotgif\Slack\Event\VerificationUrlSlackEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class VerificationUrlEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            VerificationUrlSlackEvent::EVENT_NAME => [
                'onVerificationUrl', 0
            ]
        ];
    }

    public function onVerificationUrl(VerificationUrlSlackEvent $event): void
    {
        if ($event->getSlackVerificationToken() !== $event->getProvidedVerificationToken()) {
            $event->setResponse(new JsonResponse([
                'error' => [
                    'message' => 'The provided verification token mismatch'
                ]
            ], Response::HTTP_BAD_REQUEST));

            return;
        }

        $event->setResponse(new JsonResponse([
            'challenge' => $event->getChallenge()
        ]));
    }
}
