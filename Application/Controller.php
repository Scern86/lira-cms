<?php

namespace Lira\Application;

use Lira\Framework\Config\Config;
use Lira\Framework\Lexicon\Lexicon;
use Lira\Framework\Results\Result;
use Lira\Framework\User;
use Lira\Framework\View;
use Symfony\Component\HttpFoundation\Request;

abstract class Controller extends \Lira\Framework\Controller
{
    public function __construct(
        protected Request $request,
        protected View $view,
        protected Lexicon $lexicon,
        protected User $user,
        protected Config $config
    )
    {
    }
    abstract public function execute(string $uri): Result;
}