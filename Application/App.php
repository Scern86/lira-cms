<?php

namespace Lira\Application;

use Lira\Application\Result\{InternalRedirect, Json, Redirect, Success, Error};
use Lira\Framework\Results\Result;
use Lira\Framework\Cache\CacheInterface;
use Lira\Framework\Config\Config;
use Lira\Framework\Database\DatabaseInterface;
use Lira\Framework\Events\Dispatcher;
use Lira\Framework\Lexicon\Lexicon;
use Lira\Framework\Logger\LoggerInterface;
use Lira\Framework\{Router, Session, View};
use Symfony\Component\HttpFoundation\{Request, Response};

class App
{
    private static App $instance;

    public function __construct(
        private Router $router,
        public readonly Request $request,
        public readonly Config $config,
        public readonly Lexicon $lexicon,
        public readonly DatabaseInterface $database,
        public readonly Dispatcher $eventDispatcher,
        public readonly Session $session,
        public readonly CacheInterface $cache,
        public readonly LoggerInterface $logger,
        public readonly View $view
    )
    {
        if(isset(self::$instance)) throw new \Exception('Application already started!');
        self::$instance = $this;
    }

    public static function getInstance(): self
    {
        return self::$instance;
    }

    public function execute(string $uri): Result
    {
        try {
            $class = $this->router->execute($uri);

            $controller = new $class();

            $result = $controller->execute($uri);

            return match ($result::class) {
                Success::class, Error::class, Json::class, Redirect::class => $result,
                InternalRedirect::class => $this->execute($result->url),
                default => new \Exception('Application error')
            };
        } catch (\Throwable $e) {
            return new Error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}