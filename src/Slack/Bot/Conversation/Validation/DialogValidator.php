<?php

declare(strict_types=1);

namespace Dividotlab\Slack\Bot\Conversation\Validation;

use Dividotlab\Slack\Bot\Conversation\Dialog;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @author Sylvain Lorinet <sylvain.lorinet@gmail.com>
 */
class DialogValidator
{
    /**
     * @var CamelCaseToSnakeCaseNameConverter
     */
    private $nameConverter;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(CamelCaseToSnakeCaseNameConverter $nameConverter, ValidatorInterface $validator)
    {
        $this->nameConverter = $nameConverter;
        $this->validator     = $validator;
    }

    public function isValid(Dialog $dialog): bool
    {
        $validators = [];

        foreach ($dialog->getValidators() as $inputName => $validatorsAsArray) {
            foreach ($validatorsAsArray as $validatorName => $options) {
                if ($options instanceof Constraint) {
                    $validators[$inputName][] = $options;

                    continue;
                }

                $validatorMethodName = lcfirst($this->nameConverter->denormalize($validatorName)) . 'Validator';

                if (!method_exists($this, $validatorMethodName)) {
                    throw new \InvalidArgumentException(sprintf(
                        'Dialog validator "%s" for input "%s" does not exists',
                        $validatorName,
                        $inputName
                    ));
                }

                $validators[$inputName][] = $this->{$validatorMethodName}($options);
            }
        }

        if (empty($validators)) {
            return true;
        }

        $isValid = true;

        foreach ($dialog->getData() as $inputName => $inputValue) {
            $errors = $this->validator->validate($inputValue, $validators[$inputName]);

            if (0 < $errors->count()) {
                $isValid = false;
                $dialog->addErrors($inputName, $errors);
            }
        }

        return $isValid;
    }

    protected function emailValidator(): Constraint
    {
        return new Email();
    }

    protected function phoneValidator(): Constraint
    {
        return new Length([
            'min' => 8,
            'max' => 15
        ]);
    }

    protected function numberValidator(): Constraint
    {
        return new Type('integer');
    }

    protected function urlValidator(): Constraint
    {
        return new Url();
    }

    protected function choiceValidator(array $options): Constraint
    {
        return new Choice($options);
    }

    protected function maxLengthValidator(int $length): Constraint
    {
        return new Length([
            'max' => $length
        ]);
    }

    protected function minLengthValidator(int $length): Constraint
    {
        return new Length([
            'min' => $length
        ]);
    }

    protected function requiredValidator(): Constraint
    {
        return new NotBlank();
    }
}
