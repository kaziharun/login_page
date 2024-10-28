<?php declare(strict_types=1);

namespace App\Validator;

use App\DTO\LoginDTO;

class LoginValidator
{
    public function validate(LoginDTO $loginDTO): array
    {
        $errors = [];

        if (empty($loginDTO->getEmail()) || !filter_var($loginDTO->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email format.';
        }

        if (empty($loginDTO->getPassword())) {
            $errors[] = 'Password cannot be empty.';
        }

        return $errors;
    }
}