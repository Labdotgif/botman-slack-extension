<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
abstract class SlackEvent extends Event implements SlackEventInterface
{
}
