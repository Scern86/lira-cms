<?php

namespace Lira\Components\Admin\Default;

use Lira\Application\App;
use Lira\Application\Result\Error;
use Lira\Application\View;
use Lira\Components\Admin\Admin;
use Lira\Framework\Results\Result;
use Symfony\Component\HttpFoundation\Response;

class Controller extends \Lira\Framework\Controller
{
    public function execute(string $uri): Result
    {
        $view = new View(App::getInstance()->lexicon,Admin::COMPONENT_DIR.DS.'Default'.DS.'template.inc');
        return new Error($view->render(),Response::HTTP_NOT_FOUND);
    }
}