<?php

namespace Lira\Application;

use Lira\Framework\Results\Result;
use Lira\Framework\User;

abstract class Controller extends \Lira\Framework\Controller
{
    public function __construct(
        protected User $user,
    )
    {
    }

    abstract public function execute(string $uri): Result;
}