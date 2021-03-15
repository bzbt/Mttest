<?php


namespace App\Component\Validator;


interface ValidatorInterface
{
    public function isValid(): bool;

    public function isInvalid(): bool;
}
