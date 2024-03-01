<?php

namespace Lira\Application;

use Lira\Framework\Lexicon\Lexicon;

class View extends \Lira\Framework\View
{
    protected array $headersLinks = [];
    protected array $bodysLinks = [];

    public function __construct(protected Lexicon $lexicon,string $template = '', array $values = [], bool $appendOnly = false)
    {
        parent::__construct($template,$values,$appendOnly);
    }

    public function addHeaderLink(string $link): void
    {
        if(!in_array($link,$this->headersLinks)) {
            array_push($this->headersLinks,$link);
        }
    }

    public function addBodyLink(string $link): void
    {
        if(!in_array($link,$this->bodysLinks)) {
            array_push($this->bodysLinks,$link);
        }
    }
}