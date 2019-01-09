<?php

declare(strict_types=1);

namespace Labdotgif\Slack\Bot\Conversation\Input;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class SelectOption
{
    /**
     * @var string
     */
    private $label;

    /**
     * @var mixed
     */
    private $value;

    public function __construct(string $label, $value)
    {
        $this->label = $label;
        $this->value = $value;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'value' => $this->value
        ];
    }
}
