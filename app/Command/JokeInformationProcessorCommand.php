<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use App\JokeAPI;


class JokeInformationProcessorCommand extends Command
{
    private JokeAPI $jokeAPI;

    public function __construct(JokeAPI $jokeAPI)
    {
        $this->jokeAPI = $jokeAPI;
        parent::__construct();
    }

    protected static $defaultName = 'joke:process';

    protected function configure()
    {
        $this
            ->setDescription('Process jokes')
            ->addOption('type', 't', InputOption::VALUE_OPTIONAL, 'Joke type')
            ->addOption('count', 'c', InputOption::VALUE_OPTIONAL, 'Number of jokes to fetch', 1);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Processing jokes...');

        $type = $input->getOption('type');
        $count = (int) $input->getOption('count');

        // Retrieve jokes based on the provided options
        $jokeCollection = $this->jokeAPI->getJokeByType($type);
        $jokes = $jokeCollection->getJokes();

        for ($i = 1; $i <= $count; $i++) {
            if (isset($jokes[$i - 1])) {
                $joke = $jokes[$i - 1];
                $output->writeln("Joke {$i}:");
                $output->writeln($joke->getSetup());
                $output->writeln($joke->getPunchline());
                $output->writeln('-------------------------------------------------------------');
            } else {
                $output->writeln('No more jokes available. ');
                break;
            }
        }

        return Command::SUCCESS;
    }
}