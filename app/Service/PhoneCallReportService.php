<?php


namespace App\Service;


use App\Data\Generator\DataFromCsvFile\CallsFromCsvGenerator;
use App\Dto\PhoneCallMadeDto;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhoneCallReportService
{

    public function createFromUploadedCsv(UploadedFile $file): array
    {
        try {
            $calls = (new CsvFileManager())->getCallsDataFromUploadedFile($file, new CallsFromCsvGenerator());
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        return $this->createFromCustomersCalls($calls);
    }

    private function createFromCustomersCalls(array $calls): array
    {
        $customersIds = [];
        $phoneNumbers = [];
        $ipAddresses  = [];

        /** @var PhoneCallMadeDto $call */
        foreach ($calls as $call) {
            if ( ! in_array($call->getCustomerId(), $customersIds)) {
                $customersIds[] = $call->getCustomerId();
            }

            if ( ! in_array($call->getPhoneNumber(), $phoneNumbers)) {
                $phoneNumbers[] = $call->getPhoneNumber();
            }

            if ( ! in_array($call->getIp(), $ipAddresses)) {
                $ipAddresses[] = $call->getIp();
            }
        }
        $geoCodingService     = new GoeCodingService();
        $continentsPhoneCodes = $geoCodingService->getContinentsPhoneCodes();
        $continentIpAddresses = $geoCodingService->getContinentsForIpAddresses($ipAddresses);

        return $this->parseCustomersCalls($calls, $customersIds, $continentsPhoneCodes, $continentIpAddresses);
    }

    public function parseCustomersCalls(array $customerCalls, array $customerIds, array $continentsPhoneCodes = [], array $continentIpAddresses = []): array
    {
        $calls = [];
        foreach ($customerIds as $customerId) {
            for ($i = 0; $i < count($customerCalls); ++$i) {
                /** @var PhoneCallMadeDto $callMadeDto */
                $callMadeDto = $customerCalls[$i];

                if ($callMadeDto->getCustomerId() === $customerId) {
                    $continentByIp    = $this->getContinentByIp($callMadeDto->getIp(), $continentIpAddresses);
                    $continentByPhone = $this->getContinentByPhoneNumber((string) $callMadeDto->getPhoneNumber(), $continentsPhoneCodes);

                    // If in same time IP and Phone continents are NULL. then do not commit call to NULL continent
                    $withinSameContinent = ! in_array(null, [$continentByIp, $continentByPhone])
                                           && $continentByIp == $continentByPhone;

                    $key                           = (string)$customerId;
                    $calls                         = $calls ?? [];
                    $calls[$key]                   = $calls[$key] ?? [$key => []];
                    $calls[$key]['total']          = $calls[$key]['total'] ?? 0;
                    $calls[$key]['duration']       = $calls[$key]['duration'] ?? 0;
                    $calls[$key]['same_continent'] = $calls[$key]['same_continent'] ?? ['total' => 0, 'duration' => 0];

                    $calls[$key] = [
                        'customer_id'    => $customerId,
                        'total'          => $calls[$key]['total']
                            ? ++$calls[$key]['total']
                            : 1,
                        'duration'       => $calls[$key]['duration']
                            ?
                            $calls[$key]['duration'] + $callMadeDto->getDurationInSeconds()
                            :
                            $callMadeDto->getDurationInSeconds(),
                        'same_continent' => [
                            'total'    => $withinSameContinent
                                ?
                                ++$calls[$key]['same_continent']['total']
                                :
                                $calls[$key]['same_continent']['total'],
                            'duration' => $withinSameContinent
                                ?
                                $calls[$key]['same_continent']['duration'] + $callMadeDto->getDurationInSeconds()
                                :
                                $calls[$key]['same_continent']['duration'],
                        ],
                    ];
                }
            }
        }

        return $calls;
    }

    private function getContinentByIp(string $callIp, array $continentsIpAddresses = []): ?string
    {
        foreach ($continentsIpAddresses as $continent => $ips) {
            for ($i = 0; $i < count($ips); $i++) {
                if ($callIp == $ips[$i]) {
                    return strtoupper(trim($continent));
                }
            }
        }

        return null;
    }

    private function getContinentByPhoneNumber(string $phoneNumber, array $continentsPhoneCodes = []): ?string
    {
        foreach ($continentsPhoneCodes as $continent => $phoneCodes) {
            for ($i = 0; $i < count($phoneCodes); $i++) {
                if (strpos($phoneNumber, $phoneCodes[$i]) === 0) {
                    return strtoupper(trim($continent));
                }
            }
        }

        return null;
    }
}
