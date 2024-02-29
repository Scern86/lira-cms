<?php

namespace Lira\Application;

use Lira\Framework\Logger\LoggerInterface;

class Logger implements LoggerInterface
{
    protected array $loggers = [];
    public function addLogger(\Monolog\Logger $logger)
    {
        $name = $logger->getName();
        if(!array_key_exists($name,$this->loggers)){
            $this->loggers[$name] = $logger;
        }
    }

    public function get(string $name): ?\Monolog\Logger
    {
        if(!array_key_exists($name,$this->loggers)) {
            return null;
        }
        return $this->loggers[$name];
    }
}