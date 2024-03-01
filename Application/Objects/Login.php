<?php

namespace Lira\Application\Objects;

readonly class Login
{
    public function __construct(
        public int $id=0,
        public string $created='',
        public string $ssid='',
        public string $ip_address='',
        public int $id_user=0,
        public bool $is_active=false,
        public string $component=''
    )
    {
    }
}