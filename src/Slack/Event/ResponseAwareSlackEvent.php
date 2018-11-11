<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Event;

use Symfony\Component\HttpFoundation\Response;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
abstract class ResponseAwareSlackEvent implements SlackEventInterface
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
