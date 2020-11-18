<?php


namespace App\Service;


interface ValideableInterface
{
    public function isPasswordValid(): bool;
}
