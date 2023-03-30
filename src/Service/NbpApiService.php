<?php

declare(strict_types=1);

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class NbpApiService
{
    public const NBP_API_URL = 'http://api.nbp.pl/api/';

    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::NBP_API_URL,
            'timeout' => 2.0,
        ]);
    }

    public function getExchangeRates(): array
    {
        $today = new \DateTime();
        $yesterday = new \DateTime();
        $yesterday = $yesterday->modify('-1 day');

        $response = null;

        try {
            $response = $this->client->request('GET',
                sprintf('exchangerates/tables/A/%s/%s',
                    $yesterday->format('Y-m-d'),
                    $today->format('Y-m-d')));
        } catch (GuzzleException $e) {
            $response = $this->client->request('GET',
                sprintf('exchangerates/tables/A/%s/%s',
                    $yesterday->modify('-1 day')->format('Y-m-d'),
                    $today->modify('-1 day')->format('Y-m-d')));
        }
        return  json_decode($response->getBody()->getContents(), true);
    }
}
