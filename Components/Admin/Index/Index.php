<?php

namespace Lira\Components\Admin\Index;

use Lira\Application\App;
use Lira\Components\Admin\Admin;
use Lira\Framework\Results\Result;
use Lira\Application\Result\{Redirect, Success, Error};
use Lira\Framework\View;
use Symfony\Component\HttpFoundation\Response;

class Index extends \Lira\Framework\Controller
{
    const CONTROLLER_DIR = Admin::COMPONENT_DIR . DS . 'Index';

    public function execute(string $uri): Result
    {
        if(!App::getInstance()->user->isLoggedIn()) return new Redirect(Admin::COMPONENT_URL.'/login');

        $view = new View(self::CONTROLLER_DIR.DS.'template.inc');

        App::getInstance()->view->meta_title = 'Admin panel | LiraCMS';

        return new Success($view->render(),Response::HTTP_OK);
    }
}