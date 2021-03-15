<?php

namespace AppTest\Component\Validator\CallsReport;

use App\Component\Validator\CallsReport\PhoneCallRowValidator;
use PHPUnit\Framework\TestCase;

class PhoneCallRowValidatorTest extends TestCase
{

    /**
     * @dataProvider isValidDataProvider
     */
    public function testIsValid(array $row, $expectedResult)
    {
        $validator = new PhoneCallRowValidator($row);

        $this->assertEquals($expectedResult, $validator->isValid());
    }

    public function isValidDataProvider()
    {
        return [
            [
                [
                    123, '2020-12-31 22:00:00', 123, 123123123, '0.0.0.0'
                ],
                true,
            ],
            [
                [
                    'bad_customer_id', '2020-12-31 22:00:00', 123, 123123123, '0.0.0.0'
                ],
                false,
            ],
            [
                [
                    123, '2100-01-01 00:02:00', 123, 123123123, '0.0.0.0'
                ],
                false,
            ],
            [
                [
                    123, '2000-01-01 00:02:00', -123, 123123123, '0.0.0.0'
                ],
                false,
            ],
            [
                [
                    123, '2000-01-01 00:02:00', 123, -123123123, '0.0.0.0'
                ],
                false,
            ],
            [
                [
                    123, '2000-01-01 00:02:00', 123, 123123123, 'some_strange_ip'
                ],
                false,
            ],
        ];
    }
}
