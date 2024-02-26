<?php

namespace Lira\Application;

use Lira\Framework\Database\DatabaseInterface;
use Lira\Framework\Events\Dispatcher;
use Lira\Framework\Events\Event;
use Lira\Framework\Events\EventsSupport;
use Lira\Framework\Events\Level;
use Lira\Framework\Events\Type;

class Pdo implements DatabaseInterface
{
    use EventsSupport;
    protected ?\PDO $pdo = null;

    public function __construct(Dispatcher $eventDispatcher,string $database, string $user, string $password, string $host = '127.0.0.1', int $port = 5432)
    {
        $this->initEventDispatcher($eventDispatcher);
        try {
            $dsn = "pgsql:host={$host};port={$port};dbname={$database}";
            $this->pdo = new \PDO($dsn, $user, $password);
        }catch (\Throwable $e){
            $this->eventDispatcher->dispatch(new Event(Type::ERROR,Level::WARNING,'Can`t create database connection',[$e]));
        }
    }

    public function connect(): ?\PDO
    {
        return $this->pdo;
    }
}