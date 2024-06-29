<?php

declare(strict_types=1);

namespace App\Request;

interface SelfValidatorInterface
{
    public function validate(): void;
}
