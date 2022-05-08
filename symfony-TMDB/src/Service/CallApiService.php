<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getApi(string $var)
    {
        $api_key = 'api_key=8eae384dba33ed6324a4721fd9112cf2';

        $response = $this->client->request(
            'GET',
            "https://api.themoviedb.org/3" . $var . '&' . $api_key,
        );

        return $response->toArray();
    }

    public function getPopularMovies(): array
    {
        return $this->getApi('/discover/movie?sort_by=popularity.desc');
    }

}