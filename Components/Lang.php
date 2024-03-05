<?php

namespace Lira\Components;

use Lira\Application\App;
use Lira\Application\Result\InternalRedirect;
use Lira\Application\Result\Redirect;
use Lira\Framework\Results\Result;

class Lang extends \Lira\Framework\Controller
{
    public function execute(string $uri): Result
    {
        $urlArray = array_filter(explode('/',$uri));
        $lang = array_shift($urlArray);

        $url = str_replace(['/ru'],'',$uri);
        if(empty($url)) $url = '/';

        $lexicon = App::getInstance()->lexicon;
        if($lang==$lexicon->defaultLang->code) return new Redirect($url);

        $lexicon->currentLang = new \Lira\Framework\Lexicon\Lang($lang);

        return new InternalRedirect($url);
    }
}