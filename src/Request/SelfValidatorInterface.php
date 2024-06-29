<?php

declare(strict_types=1);

namespace App\Request;

interface SelfValidatorInterface
{
    /**
     * @throws \InvalidArgumentException
     */
    public function validate(): void;
}
