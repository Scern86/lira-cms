<?php

namespace Lira\Components\Admin\Category;

use Lira\Application\App;
use Lira\Framework\Results\Result;
use Lira\Application\Result\{Success, Error, Redirect};
use Lira\Components\Admin\Admin;
use Lira\Framework\{Controller, View};
use Symfony\Component\HttpFoundation\Response;

class Category extends Controller
{
    protected Model $model;
    const CONTROLLER_DIR = Admin::COMPONENT_DIR . DS . 'Category';

    public function __construct()
    {
        $this->model = new Model(App::getInstance()->database);
    }

    public function execute(string $uri): Result
    {
        if (!App::getInstance()->user->isLoggedIn()) return new Redirect(Admin::COMPONENT_URL . '/login');

        $uri = str_replace('/category', '', $uri);
        if (empty($uri)) return $this->add($uri);
        return $this->change($uri);
    }

    private function add(string $uri): Result
    {
        if (!App::getInstance()->user->isMethodAllowed(__METHOD__)) {
            return new Error('Forbidden', Response::HTTP_FORBIDDEN);
        }

        $app = App::getInstance();
        if ($app->request->isMethod('POST')) {
            $title = trim(htmlspecialchars($app->request->get('title')));
            $idParent = (int)trim(htmlspecialchars($app->request->get('id_parent')));
            $url= trim(htmlspecialchars($app->request->get('url')));
            $result = $this->model->add($title, $idParent,$url);
            if (!empty($result)) {
                return new Redirect(Admin::COMPONENT_URL . '/category/' . $result['id']);
            }
            return new Error('Error in creating category');
        }
        $view = new View(self::CONTROLLER_DIR . DS . 'templates' . DS . 'add.inc');
        $app->view->meta_title = 'Add category';
        $view->categories = $this->model->getList();
        return new Success($view->render());
    }

    private function change(string $uri): Result
    {
        $app = App::getInstance();

        list(, $id) = explode('/', $uri);
        $id = (int)$id;

        switch ($app->request->getMethod()) {
            case 'PUT':
                return $this->update($id);
            case 'DELETE':
                return $this->delete($id);
            default:
                $view = new View(self::CONTROLLER_DIR . DS . 'templates' . DS . 'edit.inc');
                $view->item = $item = $this->model->getById($id);

                if (empty($item)) return new Error('Categry not found', Response::HTTP_NOT_FOUND);
                $app->view->meta_title = 'Edit category';
                $view->categories = $this->model->getList();
                return new Success($view->render());
        }
    }

    private function update(int $idCategory): Result
    {
        if (!App::getInstance()->user->isMethodAllowed(__METHOD__)) {
            return new Error('Forbidden', Response::HTTP_FORBIDDEN);
        }

        $app = App::getInstance();
        $title = trim(htmlspecialchars($app->request->get('title')));
        $idParent = (int)trim(htmlspecialchars($app->request->get('id_parent')));
        $url= trim(htmlspecialchars($app->request->get('url')));
        $this->model->update($idCategory, $title, $idParent, $url);
        return new Redirect(Admin::COMPONENT_URL . '/category/' . $idCategory);
    }

    private function delete(int $idCategory): Result
    {
        if (!App::getInstance()->user->isMethodAllowed(__METHOD__)) {
            return new Error('Forbidden', Response::HTTP_FORBIDDEN);
        }

        if ($this->model->delete($idCategory)) {
            return new Success('Success');

        }
        return new Error('Error');
    }
}