<?php


namespace App\Dto;


class PhoneCallMadeDto
{
    private int $customerId;
    private \DateTime $calledAt;
    private int $durationInSeconds;
    private int $phoneNumber;
    private string $ip;

    public function __construct(int $customerId, \DateTime $calledAt, int $durationInSeconds, int $phoneNumber, string $ip)
    {
        $this->customerId = $customerId;
        $this->calledAt = $calledAt;
        $this->durationInSeconds = $durationInSeconds;
        $this->phoneNumber = $phoneNumber;
        $this->ip = $ip;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getCalledAt(): \DateTime
    {
        return $this->calledAt;
    }

    public function getDurationInSeconds(): int
    {
        return $this->durationInSeconds;
    }

    public function getPhoneNumber(): int
    {
        return $this->phoneNumber;
    }

    public function getIp(): string
    {
        return $this->ip;
    }
}
