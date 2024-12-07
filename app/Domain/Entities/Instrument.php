<?php

namespace App\Domain\Entities;

class Instrument
{
    public function __construct(
        public string $name,
        public string $route,
    ) {}
}
