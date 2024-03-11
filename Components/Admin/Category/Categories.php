<?php

namespace Lira\Components\Admin\Category;

use Lira\Application\App;
use Lira\Framework\Results\Result;
use Lira\Application\Result\{Success,Error,Redirect};
use Lira\Components\Admin\Admin;
use Lira\Framework\{Controller,View};
use Symfony\Component\HttpFoundation\Response;

class Categories extends Controller
{
    protected Model $model;
    const CONTROLLER_DIR = Admin::COMPONENT_DIR.DS.'Category';

    public function __construct()
    {
        $this->model = new Model(App::getInstance()->database);
    }

    public function execute(string $uri): Result
    {
        if(!App::getInstance()->user->isLoggedIn()) return new Redirect(Admin::COMPONENT_URL.'/login');

        return $this->list();
    }

    private function list(): Result
    {
        if(!App::getInstance()->user->isMethodAllowed(__METHOD__)) {
            return new Error('Forbidden',Response::HTTP_FORBIDDEN);
        }

        App::getInstance()->view->meta_title = 'List categories';
        $view = new View(self::CONTROLLER_DIR.DS.'templates'.DS.'list.inc');
        $view->list = $this->model->getList();
        return new Success($view->render());
    }
}