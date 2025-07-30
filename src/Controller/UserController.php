<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController {
    #[Route('login', name: 'login', methods: ['POST'])]
    public function index(#[CurrentUser] ?User $user, EntityManagerInterface $em): Response {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = bin2hex(random_bytes(32));
        
        $user->setAccesstoken($token);
        $em->persist($user);
        $em->flush();

        return $this->json([
            'user'  => $user->getUserIdentifier(),
            'token' => $token
        ]);
    }
}
