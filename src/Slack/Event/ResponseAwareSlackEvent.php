<?php

declare(strict_types=1);

namespace Labdotgif\Slack\Event;

use Symfony\Component\HttpFoundation\Response;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
abstract class ResponseAwareSlackEvent extends SlackEvent
{
    /**
     * @var null|Response
     */
    private $response;

    public function getResponse(): ?Response
    {
        return $this->response;
    }

    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }
}
