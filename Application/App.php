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
use Lira\Framework\{Router, Session, User, View};
use Symfony\Component\HttpFoundation\{Request, Response};

class App
{
    private static App $instance;
    public readonly User $user;
    public readonly DatabaseInterface $database;
    public readonly Session $session;
    public readonly CacheInterface $cache;
    public readonly LoggerInterface $logger;

    public function __construct(
        private Router $router,
        public readonly Request $request,
        public readonly Config $config,
        public readonly Lexicon $lexicon,
        public readonly Dispatcher $eventDispatcher,
        public readonly View $view
    )
    {
        if(isset(self::$instance)) throw new \Exception('Application already started!');
        self::$instance = $this;
        // Method spoofing
        if ($this->request->request->has('_method')) {
            $method = $this->request->request->get('_method');
            $this->request->setMethod($method);
        }
    }

    public static function getInstance(): self
    {
        return self::$instance;
    }

    public function initUser(User $user): void
    {
        if(!isset($this->user)){
            $this->user = $user;
        }
    }
    public function initDatabase(DatabaseInterface $database): void
    {
        if(!isset($this->database)){
            $this->database = $database;
        }
    }
    public function initSession(Session $session): void
    {
        if(!isset($this->session)){
            $this->session = $session;
            $this->session->init();
        }
    }
    public function initCache(CacheInterface $cache): void
    {
        if(!isset($this->cache)){
            $this->cache = $cache;
            $this->cache->init();
        }
    }
    public function initLogger(LoggerInterface $logger): void
    {
        if(!isset($this->logger)){
            $this->logger = $logger;
        }
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