<?php

declare(strict_types=1);

namespace App\Joke;

class Joke
{
    private string $setup;
    private string $punchline;

    public function __construct(string $setup, string $punchline)
    {
        $this->setup = $setup;
        $this->punchline = $punchline;
    }

    public function getSetup(): string
    {
        return $this->setup;
    }

    public function getPunchline(): string
    {
        return $this->punchline;
    }

}
