<?php

namespace Lira\Application\Result;

use Lira\Framework\Results\Result;

readonly class InternalRedirect extends Result
{
    public function __construct(public string $url)
    {
    }
}