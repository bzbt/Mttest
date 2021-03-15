<?php


namespace App\Service;


use App\Infrastructure\GeoCodingProvider\GeoCodingProviderApiClientFactory;

class GoeCodingService
{
    public function getContinentsPhoneCodes(): ?array
    {
        $countryIoClient = (new GeoCodingProviderApiClientFactory(GeoCodingProviderApiClientFactory::COUNTRYIO))->create();

        if (empty($countryIoClient)) {
            return null;
        }

        $continents       = [];
        $continentsPhones = $countryIoClient
            ->setQuery(['continent', 'phone'])
            ->makeRequest();

        foreach ($continentsPhones['continent'] as $country => $continent) {
            $countryPhoneCode = (int) preg_replace("/[^0-9.]/", "", $continentsPhones['phone'][$country]);
            if ($countryPhoneCode > 0) {
                $continents[$continent][] = $countryPhoneCode;
            }
        }

        return $continents;
    }

    public function getContinentsForIpAddresses(array $ipAddresses): ?array
    {
        $ipStackClient = (new GeoCodingProviderApiClientFactory(GeoCodingProviderApiClientFactory::IPSTACK))->create();

        if (empty($ipStackClient)) {
            return null;
        }

        $continents = [];
        foreach ($ipAddresses as $ip) {
            $continent = $ipStackClient
                ->setQuery(
                    [
                        'ip'     => $ip,
                        'fields' => 'continent_code',
                    ]
                )
                ->makeRequest();

            if (in_array('continent_code', array_keys($continent))) {
                $continents[$continent['continent_code']][] = $ip;
            }
        }

        return $continents;
    }
}
