<?php

namespace App\Controller;

use App\Repository\PokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class PokemonController extends AbstractController
{
    #[Route('allpokemon', name: 'allpokemon')]
    public function allpokemon(PokemonRepository $pokemonRepository): JsonResponse
    {
        return $this->json($pokemonRepository->findAll(), 200, [], ['groups' => 'pokemon:list']);
    }

    #[Route('pokemon', name: 'pokemon')]
    public function pokemon(PokemonRepository $pokemonRepository): JsonResponse
    {
        return $this->json($pokemonRepository->findAll(), 200, [], ['groups' => 'pokemon:list']);
    }

    #[Route('randompokemon', name: 'randompokemon')]
    public function randompokemon(PokemonRepository $pokemonRepository): JsonResponse
    {
        return $this->json($pokemonRepository->findRandomPokemonToShow(), 200, [], ['groups' => 'pokemon:list']);
    }
}
