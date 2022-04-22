<?php

declare(strict_types=1);

namespace Labdotgif\Slack\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
abstract class SlackEvent extends Event implements SlackEventInterface
{
}
