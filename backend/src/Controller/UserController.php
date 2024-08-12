<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Guest;
use App\Entity\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route(path: 'api/me', name: 'api_get_user')]
    public function getUserInfo(): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            return new JsonResponse(['error' => 'User not authenticated'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $responseData = [
            'email' => $user->getUserIdentifier(),
        ];

        if (($user instanceof Admin || $user instanceof Manager || $user instanceof Guest) && $user->getPseudo()) {
            $responseData['pseudo'] = $user->getPseudo();
            $responseData['role'] = $user->getRoles();
  
        }

        return new JsonResponse(['username' => $responseData['pseudo'], 'role' => $responseData['role']]);
    }
}
