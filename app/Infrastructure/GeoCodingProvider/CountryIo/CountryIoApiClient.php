<?php


namespace App\Infrastructure\GeoCodingProvider\CountryIo;


use App\Infrastructure\GeoCodingProvider\GoeCodingProviderApiClientInterface;

class CountryIoApiClient implements GoeCodingProviderApiClientInterface
{
    private const ENDPOINTS
        = [
            'continent' => 'http://country.io/continent.json',
            'phone' => 'http://country.io/phone.json',
        ];

    private array $query;

    public function makeRequest(): array
    {
        $response = [];
        foreach ($this->query as $endpoint) {
            $rawData             = file_get_contents(self::ENDPOINTS[$endpoint]);
            $response[$endpoint] = json_decode($rawData, true);
        }

        return $response;
    }

    public function setQuery(array $endpoints): self
    {
        $this->query = $endpoints;

        return $this;
    }
}
