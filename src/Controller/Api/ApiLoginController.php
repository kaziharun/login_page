<?php declare(strict_types=1);

namespace App\Controller\Api;

use App\Factory\Loginfactory;
use App\Service\LoginService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApiLoginController extends AbstractController
{
    public function __construct(
        private LoginFactory $loginFactory,
        private LoginService $loginService
    )
    {
    }

    #[Route('/', name: 'api_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('login/index.html.twig');
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        try {
            $loginDTO = $this->loginFactory->createFromRequest($request);
        } catch (\InvalidArgumentException $e) {
            return $this->loginService->createErrorResponse('logout functionality are not define.', 400);
        }

        return $this->loginService->validateUserCredentials($loginDTO);
    }

    #[Route('/api/logout', name: 'api_logout', methods: ['GET'])]
    public function logout(): JsonResponse
    {
        return $this->loginService->createErrorResponse('logout functionality are not define.', 400);
    }

    #[Route('/api/register', name: 'api_register', methods: ['GET'])]
    public function register(): JsonResponse
    {
        return $this->loginService->createErrorResponse('registration functionality are not define.', 400);
    }

}
