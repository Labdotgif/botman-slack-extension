<?php

declare(strict_types=1);

namespace Labdotgif\Slack\Bot\Conversation;

use BotMan\BotMan\Interfaces\WebAccess;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class MessageRenderer
{
    const RESPONSE_TYPE_IN_CHANNEL = 'in_channel';

    /**
     * @var array|WebAccess[]
     */
    private $attachments = [];

    /**
     * @var array
     */
    private $parameters = [];

    public static function create(): self
    {
        return new static;
    }

    public function setText(string $text): self
    {
        return $this->setParameter('text', $text);
    }

    public function setResponseType(string $responseType): self
    {
        return $this->setParameter('response_type', $responseType);
    }

    /**
     * @param string           $name
     * @param string|int|array $value
     *
     * @return self
     */
    protected function setParameter(string $name, $value): self
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    public function addAttachment(WebAccess ...$attachments): self
    {
        $this->attachments[] = $attachments;

        return $this;
    }

    public function render(bool $toJson = true): array
    {
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
                $this->parameters['attachments'] = json_encode($attachments);
            } else {
                $this->parameters['attachments'] = $attachments;
            }
        }

        return $this->parameters;
    }
}
