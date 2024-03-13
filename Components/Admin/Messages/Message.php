<?php

namespace Lira\Components\Admin\Messages;

use Lira\Application\App;
use Lira\Framework\Results\Result;
use Lira\Application\Result\{Json, Success, Error, Redirect};
use Lira\Components\Admin\Admin;
use Lira\Framework\{Controller,View};
use Symfony\Component\HttpFoundation\Response;

class Message extends Controller
{
    protected Model $model;
    const CONTROLLER_DIR = Admin::COMPONENT_DIR . DS . 'Messages';

    public function __construct()
    {
        $app = App::getInstance();
        $this->model = new Model($app->database);
    }

    public function execute(string $uri): Result
    {
        if(!App::getInstance()->user->isLoggedIn()) return new Redirect(Admin::COMPONENT_URL.'/login');

        $uri = str_replace('/message', '', $uri);
        if (empty($uri)) return new Error('Message not found');
        return $this->change($uri);
    }

    private function change(string $uri): Result
    {
        $app = App::getInstance();

        list(, $id) = explode('/', $uri);
        $id = (int)$id;

        switch ($app->request->getMethod()) {
            case 'DELETE':
                return $this->delete($id);
            default:
                $view = new View(self::CONTROLLER_DIR . DS . 'templates' . DS . 'show.inc');
                $view->item = $item = $this->model->getById($id);

                if (empty($item)) return new Error('Message not found', Response::HTTP_NOT_FOUND);
                $app->view->meta_title = 'Show message';
                return new Success($view->render());
        }
    }
    private function delete(int $idArticle): Result
    {
        if(!App::getInstance()->user->isMethodAllowed(__METHOD__)) {
            return new Error('Forbidden',Response::HTTP_FORBIDDEN);
        }

        if ($this->model->delete($idArticle)) {
            return new Success('Success');

        }
        return new Error('Error');
    }
}