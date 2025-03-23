<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Bus\Command;

use Illuminate\Support\Str;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class CommandValidate implements CommandInterface
{
    public function validate(): void
    {
        /** @var ConstraintViolationListInterface $errors */
        $errors = resolve(ValidatorInterface::class)->validate($this);

        if ($errors->count() > 0) {
            throw new ValidationFailedException($this->parseErrorData($errors), $errors);
        }
    }

    private function parseErrorData(ConstraintViolationListInterface $errors): array
    {
        $messages = ['message' => 'Validation errors!', 'errors' => []];

        /** @var \Symfony\Component\Validator\ConstraintViolation $message */
        foreach ($errors as $message) {
            $messages['errors'][] = [
                'message' => $message->getMessage(),
                'property' => Str::snake($message->getPropertyPath()),
                'value' => $message->getInvalidValue(),
            ];
        }

        return $messages;
    }
}