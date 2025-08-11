<?php

namespace App\Controller;

use App\Repository\PokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class PokemonController extends AbstractController
{
    #[Route('/pokemon', name: 'pokemon')]
    public function index(PokemonRepository $pokemonRepository): JsonResponse
    {
        return $this->json($pokemonRepository->findAll(), 200, [], ['groups' => 'pokemon:list']);
    }
}
