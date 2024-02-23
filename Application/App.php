<?php

namespace Lira\Application;

use Lira\Application\Result\Success;
use Lira\Framework\Results\Result;

class App extends Controller
{
    public function execute(string $uri): Result
    {
        return new Success();
    }
}