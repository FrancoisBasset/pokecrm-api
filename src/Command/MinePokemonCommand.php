<?php

namespace App\Command;

use App\Entity\Pokemon;
use App\Repository\PokemonRepository;
use App\Service\MiningService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'minePokemon',
    description: 'Mine some Pokemon',
)]
class MinePokemonCommand extends Command
{
    public function __construct(private PokemonRepository $pokemonRepository)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('pokedex_id', InputArgument::OPTIONAL, 'ID du Pokédex');
    }

    private function getRandomSalt() {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $random_length = random_int(1, 10);

        $salt = '';
        for ($i = 0; $i < $random_length; $i++) {
            $salt .= $chars[random_int(0, 61)];
        }

        return $salt;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $pokedex_id = $input->getArgument('pokedex_id');
        
        if (!$pokedex_id) {
            $pokedex_id = $io->askQuestion(new Question('Pokedex ID :'));
        }

        if (!$pokedex_id) {
            $io->error('Merci de renseigner le Pokédex ID !');
            return Command::INVALID;
        }

        $pokemon = $this->pokemonRepository->find($pokedex_id);
        if (!$pokemon) {
            $io->error('Ce Pokémon n\'existe pas !');
            return Command::INVALID;
        }

        $pokemonName = $pokemon->getName();
        $catchrate = $pokemon->getCatchrate();

        $io->info('Pokémon ' . $pokemonName);
        $io->info('Catchrate ' . $catchrate);

        $found = false;
        $salt = '';

        $table = $io->createTable();
        $table->setHeaders(['Salt', 'Hash']);
        $table->render();

        while (!$found) {
            $salt = $this->getRandomSalt();
            $hash = md5($pokemonName . $salt);

            $table->appendRow([$salt, $hash]);
            
            $found = MiningService::checkCorrectHash($catchrate, $hash);
        }

        $io->success('FOUND : ' . $salt);

        return Command::SUCCESS;
    }
}
