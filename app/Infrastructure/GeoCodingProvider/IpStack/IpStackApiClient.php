<?php


namespace App\Infrastructure\GeoCodingProvider\IpStack;


use App\Infrastructure\GeoCodingProvider\GoeCodingProviderApiClientInterface;

class IpStackApiClient implements GoeCodingProviderApiClientInterface
{
    private const ENDPOINT = 'http://api.ipstack.com';

    private string $apiKey;
    private array $query;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function setQuery(array $query)
    {
        $this->query = $query;

        return $this;
    }

    public function makeRequest()
    {
        $ip = $this->query['ip'];
        $fields = $this->query['fields'];

        if (empty($ip)) {
            return null;
        } elseif (is_array($fields)) {
            $fields = implode(',', $fields);
        }

        $url = self::ENDPOINT."/{$ip}?access_key={$this->apiKey}";
        if ( ! empty($fields)) {
            $url .= '&fields='.trim($fields);
        }

        $rawData = file_get_contents($url);

        return json_decode($rawData, true);
    }
}
