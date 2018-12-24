<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Bot\Conversation\Attachment;

use BotMan\BotMan\Messages\Outgoing\Actions\Button as BaseButton;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class Button extends BaseButton
{
    const STYLE_DEFAULT = 'default';
    const STYLE_SUCCESS = 'primary';
    const STYLE_DANGER  = 'danger';

    /**
     * @var array|null
     */
    private $confirmation;

    /**
     * @var string
     */
    private $style = self::STYLE_DEFAULT;

    /**
     * @var string|null
     */
    private $url;

    public function setConfirmation(
        string $title,
        string $text = null,
        string $confirmationButtonText = 'Confirmer',
        string $dismissButtonText = 'Annuler'
    ): self {
        $this->confirmation = [
            'title'        => $title,
            'text'         => $text,
            'ok_text'      => $confirmationButtonText,
            'dismiss_text' => $dismissButtonText
        ];

        return $this;
    }

    public function setStyle(string $style): self
    {
        $styles = [
            static::STYLE_DEFAULT, static::STYLE_DANGER, static::STYLE_SUCCESS
        ];

        if (!\in_array($style, $styles, true)) {
            throw new \InvalidArgumentException(
                'Invalid button style "' . $style . '", available : "' . implode('", "', $styles) . '"'
            );
        }

        $this->style = $style;

        return $this;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function toArray(): array
    {
        $array = array_merge(parent::toArray(), [
            'style' => $this->style,
        ]);

        if (isset($this->url)) {
            $array['url'] = $this->url;
        }

        if (!isset($this->confirmation)) {
            return $array;
        }

        return array_merge($array, [
            'confirm' => $this->confirmation
        ]);
    }
}
