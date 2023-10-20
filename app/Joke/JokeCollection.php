<?php

declare(strict_types=1);

namespace App\Joke;

class JokeCollection
{
    private array $jokes;

    public function __construct(array $jokes = [])
    {
        $this->jokes = $jokes;
    }

    public function getJokes(): array
    {
        return $this->jokes;
    }

    public function add(Joke $joke)
    {
        $this->jokes [] = $joke;
    }
}