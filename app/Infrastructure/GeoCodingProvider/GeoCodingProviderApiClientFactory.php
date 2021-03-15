<?php


namespace App\Infrastructure\GeoCodingProvider;


use App\Infrastructure\GeoCodingProvider\CountryIo\CountryIoApiClient;
use App\Infrastructure\GeoCodingProvider\IpStack\IpStackApiClient;

class GeoCodingProviderApiClientFactory
{
    public const IPSTACK = 0;
    public const COUNTRYIO = 1;

    private const IPSTACK_APIKEY = IPSTACK_APIKEY;

    private int $provider;

    public function __construct(int $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @return CountryIoApiClient|IpStackApiClient|void
     */
    public function create()
    {
        switch ($this->provider) {
            case self::IPSTACK:
                return (new IpStackApiClient(self::IPSTACK_APIKEY));
            case self::COUNTRYIO:
                return (new CountryIoApiClient());
            default:
                return;
        }
    }
}
