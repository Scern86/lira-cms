<?php

namespace Lira\Application;

use Lira\Framework\Lexicon\Lexicon;

class View extends \Lira\Framework\View
{
    public function __construct(protected Lexicon $lexicon,string $template = '', array $values = [], bool $appendOnly = false)
    {
        parent::__construct($template,$values,$appendOnly);
    }
}