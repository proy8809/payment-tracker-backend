<?php

declare(strict_types=1);

namespace App\Shared\Port\Rest\Controller;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Service\Attribute\Required;

trait ValidatesMessageTrait
{
    private ValidatorInterface $validator;

    #[Required]
    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    /**
     * @return string[]
     */
    protected function validate(mixed $toValidate): array
    {
        if (!$violations = $this->validator->validate($toValidate)) {
            return [];
        }

        $validationErrors = [];
        foreach ($violations as $violation) {
            $validationErrors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $validationErrors;
    }
}
