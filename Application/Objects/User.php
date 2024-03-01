<?php

namespace Lira\Application\Objects;

readonly class User
{
    public function __construct(
        public int $id=0,
        public string $name='',
        public string $login='',
        public string $component='',
        public bool $is_active=false
    )
    {
    }
}