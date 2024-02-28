<?php

namespace Lira\Application\Events;

use Lira\Framework\Events\{Event,Level};
use Lira\Application\App;

readonly abstract class BaseEvent extends Event
{
    public function __construct(Level $level,string $name,array $data=[])
    {
        parent::__construct($level,$name,$data);
        App::getInstance()->eventDispatcher->triggerEvent($this);
    }
}