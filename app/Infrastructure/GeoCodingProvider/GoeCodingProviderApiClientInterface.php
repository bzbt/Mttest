<?php


namespace App\Infrastructure\GeoCodingProvider;


interface GoeCodingProviderApiClientInterface
{
    public function setQuery(array $fields);

    public function makeRequest();
}
