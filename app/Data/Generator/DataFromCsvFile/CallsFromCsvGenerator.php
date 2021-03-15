<?php


namespace App\Data\Generator\DataFromCsvFile;


use App\Component\Validator\CallsReport\PhoneCallRowValidator;
use App\Data\Collector\AbstractDataCollector;
use App\Dto\PhoneCallMadeDto;

class CallsFromCsvGenerator extends AbstractDataCollector
{
    public function generate(string $filePathName): array
    {
        $calls     = [];
        $generator = $this->getDataFromCsv($filePathName);

        while ($generator->valid()) {
            $row = $generator->current();
            if ( ! empty($row) && (new PhoneCallRowValidator($row))->isValid()) {
                $row[1]  = \DateTime::createFromFormat('Y-m-d H:i:s', $row[1]);
                $calls[] = (new PhoneCallMadeDto(...$row));
            }

            $generator->next();
        }

        return $calls;
    }
}
