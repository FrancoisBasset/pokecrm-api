<?php

namespace App\Command;

use App\Entity\Pokemon;
use App\Repository\PokemonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'fetchAllPokemon',
    description: 'Fetch all Pokéémon from PokéAPI',
)]
class FetchAllPokemonCommand extends Command {
    public function __construct(private HttpClientInterface $client, private EntityManagerInterface $em, private PokemonRepository $pokemonRepository) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $this->em->createQuery('DELETE FROM App\Entity\Pokemon')->execute();
        $this->em->getConnection()->executeStatement('UPDATE sqlite_sequence SET seq = 0 WHERE name = "pokemon"');

        $response = $this->client->request(
            'GET',
            'https://tyradex.vercel.app/api/v1/pokemon'
        );
        $content = $response->getContent();
        $allPokemon = json_decode($content, false);

        foreach ($allPokemon as $pokemon) {
            if ($pokemon->pokedex_id === 0) {
                continue;
            }

            $newPokemon = new Pokemon();
            $newPokemon->setName($pokemon->name->fr);
            $newPokemon->setEnglishName($pokemon->name->en);
            $newPokemon->setGeneration($pokemon->generation);

            $newPokemon->setSprite($pokemon->sprites->regular);

            $newPokemon->setTypes(array_map(fn($t) => $t->name, $pokemon->types));

            $height = explode(' ', $pokemon->height)[0];
            $height = str_replace(',', '.', $height);
            $newPokemon->setHeight((float) $height);

            $weight = explode(' ', $pokemon->weight)[0];
            $weight = str_replace(',', '.', $weight);
            $newPokemon->setWeight((float) $weight);

            $newPokemon->setCatchrate($pokemon->catch_rate);

            $this->em->persist($newPokemon);
        }

        $this->em->flush();

        return Command::SUCCESS;
    }
}
