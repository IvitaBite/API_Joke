<?php

declare(strict_types=1);

namespace App;

use App\Joke\Joke;
use App\Joke\JokeCollection;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class JokeAPI
{
    private Client $http;

    public function __construct()
    {
        $this->http = new Client();
    }

    public function getRandomJoke(): ?JokeCollection
    {
        $apiUrl = "https://official-joke-api.appspot.com/random_joke";

        try {
            $response = $this->http->get($apiUrl);
        } catch (GuzzleException $e) {
            echo "GuzzleException: " . $e->getMessage() . "\n";
            return null;
        }

        $data = json_decode($response->getBody()->__toString(), true);

        if (!is_array($data) || !isset($data['setup']) || !isset($data['punchline'])) {
            echo "Error: JSON data is missing required fields for a joke.\n";
            return null;
        }

        $joke = new Joke(
            $data["setup"],
            $data["punchline"]
        );

        $jokeCollection = new JokeCollection();
        $jokeCollection->add($joke);

        return $jokeCollection;
    }

    public function getJokeByType(string $type): ?JokeCollection
    {
        $apiUrl = "https://official-joke-api.appspot.com/jokes/{$type}/random";

        try {
            $response = $this->http->get($apiUrl);
        } catch (GuzzleException $e) {
            echo "GuzzleException: " . $e->getMessage() . "\n";
            return null;
        }

        $data = json_decode($response->getBody()->__toString(), true);

        if (!is_array($data) || empty($data)) {
            echo "Error: No jokes found for the given type.\n";
            return null;
        }

        $jokeCollection = new JokeCollection();

        foreach ($data as $jokeData) {
            if (isset($jokeData['setup']) && isset($jokeData['punchline'])) {
                $joke = new Joke(
                    $jokeData['setup'],
                    $jokeData['punchline']
                );
                $jokeCollection->add($joke);
            }
        }

        return $jokeCollection;
    }

}