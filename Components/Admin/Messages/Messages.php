<?php

namespace Lira\Components\Admin\Messages;

use Lira\Application\App;
use Lira\Application\Result\Error;
use Lira\Application\Result\Redirect;
use Lira\Application\Result\Success;
use Lira\Components\Admin\Admin;
use Lira\Framework\Controller;
use Lira\Framework\Results\Result;
use Lira\Framework\View;
use Symfony\Component\HttpFoundation\Response;

class Messages extends Controller
{
    protected Model $model;
    const CONTROLLER_DIR = Admin::COMPONENT_DIR.DS.'Messages';

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

        App::getInstance()->view->meta_title = 'List messages';
        $view = new View(self::CONTROLLER_DIR.DS.'templates'.DS.'list.inc');
        $view->listMessages = $this->model->getList();
        return new Success($view->render());
    }
}