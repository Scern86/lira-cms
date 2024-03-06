<?php

namespace Lira\Components\Admin\Index;

use Lira\Application\App;
use Lira\Application\Models\Article;
use Lira\Framework\Results\Result;
use Lira\Application\Result\{Success,Error};
use Lira\Components\Front\Front;
use Lira\Framework\View;
use Symfony\Component\HttpFoundation\Response;

class Index extends \Lira\Framework\Controller
{
    const CONTROLLER_DIR = Front::COMPONENT_DIR . DS . 'Index';

    public function execute(string $uri): Result
    {
        $view = new View(self::CONTROLLER_DIR.DS.'template.inc');

        App::getInstance()->view->meta_title = 'Admin panel | LiraCMS';

        return new Success($view->render(),Response::HTTP_OK);
    }
}