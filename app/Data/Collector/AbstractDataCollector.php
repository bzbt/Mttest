<?php


namespace App\Data\Collector;


abstract class AbstractDataCollector
{
    protected function getDataFromCsv($filePathName): \Generator
    {
        $stream = fopen($filePathName, 'r');
        while (feof($stream) === false) {
            yield fgetcsv($stream);
        }

        fclose($stream);
    }
}
