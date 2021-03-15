<?php


namespace App\Service;


use App\Component\Validator\FileValidator\CsvFileValidator;
use App\Data\Generator\DataFromCsvFile\CallsFromCsvGenerator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CsvFileManager
{
    public function getCallsDataFromUploadedFile(UploadedFile $file, CallsFromCsvGenerator $generator): array
    {
        $isInvalid = (new CsvFileValidator(
            $file->getError(),
            $file->getSize(),
            $file->getMimeType())
        )->isInvalid();

        if ($isInvalid) {
            throw new \Exception("Unrecognized format of {$file->getClientOriginalName()}.");
        }

        return $generator->generate($file->getPathname());
    }
}
