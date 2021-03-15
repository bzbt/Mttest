<?php


namespace App\Component\Validator\FileValidator;


use App\Component\Validator\ValidatorInterface;

class CsvFileValidator implements ValidatorInterface
{
    public const ACCEPTABLE_MIME_TYPE = [
        'text/csv',
        'text/plain',
    ];

    private int $error;
    private string $mimeType;
    private int $size;

    public function __construct(int $error, int $size, ?string $mimeType)
    {
        $this->error    = $error;
        $this->size     = $size;
        $this->mimeType = strtolower($mimeType);
    }

    public function isInvalid(): bool
    {
        return ! $this->isValid();
    }

    public function isValid(): bool
    {
        return $this->error == 0
               && $this->size > 0
               && in_array($this->mimeType, self::ACCEPTABLE_MIME_TYPE);
    }
}
