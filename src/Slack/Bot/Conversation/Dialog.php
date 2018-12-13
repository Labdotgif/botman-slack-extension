<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Bot\Conversation;

use BotMan\Drivers\Slack\Extensions\Dialog as BaseDialog;
use Dividotlab\Slack\Bot\Conversation\Input\SelectOption;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
abstract class Dialog extends BaseDialog
{
    /**
     * @var string
     */
    private $state;

    protected function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    protected function setCallbackId(string $callbackId): self
    {
        $this->callbackId = $callbackId;

        return $this;
    }

    protected function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function select(string $label, string $name, array $options = [], $additional = [])
    {
        $optionsAsArray = [];

        foreach ($options as $option) {
            if ($option instanceof SelectOption) {
                $optionsAsArray[] = [
                    'label' => $option->getLabel(),
                    'value' => $option->getValue()
                ];
            } else {
                $optionsAsArray[] = $option;
            }
        }

        $this->add($label, $name, 'select', array_merge($additional, [
            'options' => $optionsAsArray
        ]));
    }

    public function toArray()
    {
        $payload = parent::toArray();

        if (isset($this->state)) {
            $payload = array_merge($payload, [
                'state' => $this->state
            ]);
        }

        return $payload;
    }
}
