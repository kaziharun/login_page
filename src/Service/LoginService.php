<?php declare(strict_types=1);

namespace App\Service;

use App\DTO\LoginDTO;
use App\Repository\UserRepository;
use App\Validator\LoginValidator;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginService
{
    public function __construct(
        private UserRepository $userRepository,
        private LoginValidator $loginValidator
    )
    {
    }

    public function validateUserCredentials(LoginDTO $loginDTO): JsonResponse
    {

        $validationErrors = $this->loginValidator->validate($loginDTO);
        if (!empty($validationErrors)) {
            return $this->createErrorResponse(implode(', ', $validationErrors), 400);
        }

        if ($this->authenticate($loginDTO)) {
            $response = $this->createSuccessResponse($loginDTO->getEmail());
            if ($loginDTO->isRememberMe()) {
                $this->createRememberMeToken($response);
            }

            return $response;
        }

        return $this->createErrorResponse('Invalid email or password.', 401);
    }

    public function authenticate(LoginDTO $loginDTO): bool
    {
        $user = $this->userRepository->findByEmail($loginDTO->getEmail());

        if ($user && $loginDTO->getPassword() === $user->getPassword()) {
            return true;
        }

        return false;
    }

    private function createRememberMeToken(JsonResponse $response): void
    {
        $series = bin2hex(random_bytes(16));
        $token = bin2hex(random_bytes(16));
        $expiration = new \DateTime('+2 weeks');

        $response->headers->setCookie(new Cookie('series', $series, $expiration));
        $response->headers->setCookie(new Cookie('token', $token, $expiration));
    }

    public function createSuccessResponse(string $email): JsonResponse
    {
        return new JsonResponse([
            'status' => 'ok',
            'message' => sprintf("Hello User, you are logged in as %s.", htmlspecialchars($email))
        ]);
    }

    public function createErrorResponse(string $message, int $statusCode): JsonResponse
    {
        return new JsonResponse([
            'status' => 'not-ok',
            'message' => $message
        ], $statusCode);
    }
}