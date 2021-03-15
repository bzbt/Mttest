<?php


namespace App\Component\Validator\CallsReport;


use App\Component\Validator\ValidatorInterface;

class PhoneCallRowValidator implements ValidatorInterface
{

    private int $customerId;
    private \DateTime $calledAt;
    private int $durationInSeconds;
    private int $phoneNumber;
    private string $ip;

    public function __construct(array $row)
    {
        [$customerId, $calledAt, $durationInSeconds, $phoneNumber, $ip] = $row;
        $this->customerId        = (int)$customerId;
        $this->calledAt          = \DateTime::createFromFormat('Y-m-d H:i:s', $calledAt);
        $this->durationInSeconds = (int)$durationInSeconds;
        $this->phoneNumber       = (int)$phoneNumber;
        $this->ip                = $ip;
    }

    public function isInvalid(): bool
    {
        return ! $this->isValid();
    }

    public function isValid(): bool
    {
        return $this->customerId > 0
               && $this->calledAt < (new \DateTime())
               && $this->durationInSeconds > 0
               && $this->phoneNumber > 0
               && filter_var($this->ip, FILTER_VALIDATE_IP);
    }
}
