<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use Symfony\Component\Console\Application;
use App\Command\JokeInformationProcessorCommand;
use App\JokeAPI;

$jokeAPI = new JokeAPI();
$application = new Application();
$application->add(new JokeInformationProcessorCommand($jokeAPI));
$application->run();
