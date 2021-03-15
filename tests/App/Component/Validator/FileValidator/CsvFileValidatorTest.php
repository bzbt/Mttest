<?php

namespace AppTest\Component\Validator\FileValidator;

use App\Component\Validator\CallsReport\PhoneCallRowValidator;
use App\Component\Validator\FileValidator\CsvFileValidator;
use PHPUnit\Framework\TestCase;

class CsvFileValidatorTest extends TestCase
{
    /**
     * @dataProvider isValidDataProvider
     */
    public function testIsValid($error, $size, $mimeType, $expectedResult)
    {
        $validator = new CsvFileValidator($error, $size, $mimeType);

        $this->assertEquals($expectedResult, $validator->isValid());
    }

    public function isValidDataProvider()
    {
        return [
            [
                0,
                1,
                'text/plain',
                true,
            ],
            [
                1,
                1,
                'text/plain',
                false,
            ],
            [
                0,
                1,
                'image/png',
                false,
            ],
        ];
    }
}
