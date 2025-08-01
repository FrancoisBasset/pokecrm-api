<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PokemonRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController {
    #[Route('/signup', name: 'signup', methods: ['POST'])]
    public function signup(Request $request, EntityManagerInterface $em, UserRepository $userRepository, PokemonRepository $pokemonRepository): Response {
        $data = json_decode($request->getContent(), true);

        $existingUser = $userRepository->findBy(['username' => $data['username']]);
        if ($existingUser) {
            return new JsonResponse([
                'message' => "L'utilisateur " . $data['username'] . " existe déjà !"
            ], 409);
        }

        $user = new User();
        $user->setUsername($data['username']);
        $user->setPassword($data['password']);
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setRoles(['ROLE_USER']);
        $user->setStorage('FREE');
        
        $pokemonCount = $pokemonRepository->count();
        $pokemonId = random_int(1, $pokemonCount);
        $pokemon = $pokemonRepository->find($pokemonId);
        $user->addPokemonOwned($pokemon);
        
        $em->persist($user);
        $em->flush();

        return new JSONResponse([
            'message' => 'L\'utilisateur a bien été créé !'
        ], 201);
    }

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

    #[Route('mypokemon', name: 'mypokemon', methods: ['GET'])]
    public function mypokemon(#[CurrentUser] ?User $user): Response {
        return $this->json($user->getPokemonOwneds());
    }
}
