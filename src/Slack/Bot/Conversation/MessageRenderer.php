<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Bot\Conversation;

use BotMan\BotMan\Interfaces\WebAccess;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class MessageRenderer
{
    /**
     * @var array|WebAccess[]
     */
    private $attachments = [];

    public static function create(): self
    {
        return new static;
    }

    public function addAttachment(WebAccess ...$attachments): self
    {
        $this->attachments[] = $attachments;

        return $this;
    }

    public function render(bool $toJson = true): array
    {
        $parameters = [];
        $attachments = [];

        /** @var WebAccess[]|array $attachment */
        foreach ($this->attachments as $i => $attachment) {
            $attachments[$i] = [];

            foreach ($attachment as $aAttachment) {
                $attachments[$i] = array_merge($attachments[$i], $aAttachment->toWebDriver());
            }
        }

        if (!empty($attachments)) {
            if ($toJson) {
                $parameters['attachments'] = json_encode($attachments);
            } else {
                $parameters['attachments'] = $attachments;
            }
        }

        return $parameters;
    }
}
