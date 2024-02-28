<?php

namespace Lira\Components;

use Lira\Application\Controller;
use Lira\Application\Result\Error;
use Lira\Framework\Results\Result;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function execute(string $uri): Result
    {
        return new Error('404 Not found',Response::HTTP_NOT_FOUND);
    }
}