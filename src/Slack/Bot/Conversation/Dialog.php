<?php

declare(strict_types=1);

namespace Labdotgif\Slack\Bot\Conversation;

use BotMan\Drivers\Slack\Extensions\Dialog as BaseDialog;
use Labdotgif\Slack\Bot\Conversation\Input\SelectOption;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
abstract class Dialog extends BaseDialog
{
    public const TYPE_TEXT     = 'text';
    public const TYPE_TEXTAREA = 'textarea';
    public const TYPE_CHOICE   = 'select';

    public const SUB_TYPE_EMAIL        = 'email';
    public const SUB_TYPE_URL          = 'url';
    public const SUB_TYPE_PHONE_NUMBER = 'tel';
    public const SUB_TYPE_NUMBER       = 'number';

    /**
     * @var string
     */
    private $state;

    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var array
     */
    private $data;

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

        if (isset($additional['option_groups'])) {
            foreach ($additional['option_groups'] as $group) {
                $currentOptionsAsArray = [];

                foreach ($group['options'] as $option) {
                    if ($option instanceof SelectOption) {
                        $currentOptionsAsArray[] = $option->toArray();
                    } else {
                        $currentOptionsAsArray[] = $option;
                    }
                }

                $optionsAsArray[] = [
                    'label'   => $group['label'],
                    'options' => $currentOptionsAsArray
                ];
            }

            $this->add($label, $name, 'select', array_merge($additional, [
                'option_groups' => $optionsAsArray
            ]));
        } else {
            foreach ($options as $option) {
                if ($option instanceof SelectOption) {
                    $optionsAsArray[] = $option->toArray();
                } else {
                    $optionsAsArray[] = $option;
                }
            }

            $this->add($label, $name, 'select', array_merge($additional, [
                'options' => $optionsAsArray
            ]));
        }
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

    public function handleSubmission(array $submission): void
    {
        if (empty($this->elements)) {
            $this->buildForm();
        }

        $this->data = [];

        foreach ($this->elements as $element) {
            if (!isset($submission[$element['name']])) {
                $this->data[$element['name']] = null;

                continue;
            }

            $this->data[$element['name']] = $submission[$element['name']];
        }
    }

    public function getData(): array
    {
        if (!isset($this->data)) {
            throw new \LogicException('You should call Dialog::handleSubmission(array $submission) first');
        }

        return $this->data;
    }

    public function addErrors(string $inputName, ConstraintViolationListInterface $errors): self
    {
        $this->errors[$inputName] = $errors;

        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getErrorsAsArray(): array
    {
        $errors = [];

        foreach ($this->getErrors() as $inputName => $inputErrors) {
            /** @var ConstraintViolation $inputError */
            foreach ($inputErrors as $inputError) {
                $errors[] = [
                    'name'  => $inputName,
                    'error' => $inputError->getMessage()
                ];
            }
        }

        return [
            'errors' => $errors
        ];
    }

    public function getValidators(): array
    {
        if (empty($this->elements)) {
            $this->buildForm();
        }

        $validators = [];

        foreach ($this->elements as $element) {
            if (\in_array($element['type'], [
                self::TYPE_TEXT,
                self::TYPE_TEXTAREA
            ], true)) {
                $nativeValidators = ['max_length', 'min_length', 'subtype'];

                foreach ($nativeValidators as $validator) {
                    if (isset($element[$validator])) {
                        $validators[$element['name']][$validator] = $element[$validator];
                    }
                }
            }

            if (!isset($element['optional']) || false === $element['optional']) {
                $validators[$element['name']]['required'] = true;
            }

            if (self::TYPE_CHOICE === $element['type']) {
                if (isset($element['options'])) {
                     $options = array_column($element['options'], 'value');
                } else {
                    $options = [];

                    foreach ($element['option_groups'] as $group) {
                        foreach ($group['options'] as $option) {
                            $options[] = $option['value'];
                        }
                    }
                }

                $validators[$element['name']]['choice'] = $options;
            }

            if (isset($element['validators'])) {
                if (isset($validators[$element['name']])) {
                    $validators[$element['name']] = array_merge($validators[$element['name']], $element['validators']);
                } else {
                    $validators[$element['name']] = $element['validators'];
                }
            }
        }

        return $validators;
    }

    abstract protected function getCallbackId(): string;

    abstract protected function getTitle(): string;
}
