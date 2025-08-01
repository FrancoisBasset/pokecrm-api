<?php

namespace App\Controller;

use App\Repository\PokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class PokemonController extends AbstractController
{
    #[Route('/pokemon', name: 'pokemon')]
    public function index(PokemonRepository $pokemonRepository, SerializerInterface $serializer): JsonResponse
    {
        return $this->json($pokemonRepository->findAll(), 200, [], ['groups' => 'pokemon:list']);
    }
}
