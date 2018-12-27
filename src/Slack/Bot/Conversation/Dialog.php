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
    public const TYPE_TEXT     = 'text';
    public const TYPE_TEXTAREA = 'textarea';
    public const TYPE_CHOICE   = 'select';

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

    public function add(string $label, string $name, string $type, array $additional = [])
    {
        parent::add($label, $name, $type, $additional);

        return $this;
    }

    public function toArray()
    {
        $this->setCallbackId($this->getCallbackId());
        $this->setTitle($this->getTitle());

        $payload = parent::toArray();

        if (isset($this->state)) {
            $payload = array_merge($payload, [
                'state' => $this->state
            ]);
        }

        return $payload;
    }

    abstract protected function getCallbackId(): string;

    abstract protected function getTitle(): string;
}
