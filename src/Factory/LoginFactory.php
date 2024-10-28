<?php declare(strict_types=1);

namespace App\Factory;

use App\DTO\LoginDTO;
use Symfony\Component\HttpFoundation\Request;

class LoginFactory
{
    public function createFromRequest(Request $request): LoginDTO
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE || empty($data['email']) || empty($data['password'])) {
            throw new \InvalidArgumentException('Email and password are required.');
        }

        $email = $data['email'];
        $password = md5($data['password']);
        $rememberMe = isset($data['rememberMe']) && $data['rememberMe'] === true;

        return new LoginDTO($email, $password, $rememberMe);
    }
}