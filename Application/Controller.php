<?php

namespace Lira\Application;

use Lira\Framework\Cache\CacheInterface;
use Lira\Framework\Config\Config;
use Lira\Framework\Database\DatabaseInterface;
use Lira\Framework\Events\Dispatcher;
use Lira\Framework\Lexicon\Lexicon;
use Lira\Framework\Logger\LoggerInterface;
use Lira\Framework\Results\Result;
use Lira\Framework\Session;
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
        protected Config $config,
        protected DatabaseInterface $database,
        protected Dispatcher $eventDispatcher,
        protected Session $session,
        protected CacheInterface $cache,
        protected LoggerInterface $logger
    )
    {
    }

    abstract public function execute(string $uri): Result;
}