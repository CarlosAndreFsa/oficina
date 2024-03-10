<?php

namespace App\Support\Table;

class Header
{
    public function __construct(
        public string $key,
        public string $label,
        public string $class,
    ) {
    }

    public static function make(string $key, string $label, string $class = ''): self
    {
        return new self($key, $label, $class);
    }
}
