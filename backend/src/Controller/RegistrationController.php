<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route; 


class RegistrationController extends AbstractController
{

    #[Route('/register', name: 'api_register', methods: ['POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
    ): JsonResponse {
        $jsonData = json_decode($request->getContent(), true);

        if (empty($jsonData)) {
            return $this->json(['message' => 'Invalid JSON data'], 400);
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user,  array('csrf_protection' => false));

        // Submit the JSON data to the form
        $form->submit($jsonData);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $email = $form->get('email')->getData();
            // $username = $this->extractUsernameFromEmail($email);
            // $user->setUsername($username);

            $user->setRoles(["ROLE_USER"]);
            $entityManager->persist($user);
            $entityManager->flush();


            // Renvoyer le token JWT en JSON
            return new JsonResponse(['message' => 'success'], 201);
        }

        // If the form is not valid, return the errors as JSON
        $errors = $this->getFormErrors($form);
        return new JsonResponse($errors, 400);
    }

    // private function extractUsernameFromEmail(string $email): string
    // {
    //     // Get the first part of the email before the @ symbol
    //     $parts = explode('@', $email);
    //     return $parts[0];
    // }

    private function getFormErrors(\Symfony\Component\Form\Form $form): array
    {
        $errors = [];
        foreach ($form->getErrors(true, true) as $error) {
            $errors[$error->getOrigin()->getName()][] = $error->getMessage();
        }

        return $errors;
    }
}
