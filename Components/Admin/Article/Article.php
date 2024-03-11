<?php

namespace Lira\Components\Admin\Article;

use Lira\Application\App;
use Lira\Framework\Results\Result;
use Lira\Application\Result\{Json, Success, Error, Redirect};
use Lira\Components\Admin\Admin;
use Lira\Framework\{Controller,View};
use Symfony\Component\HttpFoundation\Response;

class Article extends Controller
{
    protected Model $model;
    const CONTROLLER_DIR = Admin::COMPONENT_DIR . DS . 'Article';

    public function __construct()
    {
        $app = App::getInstance();
        $this->model = new Model($app->database);
    }

    public function execute(string $uri): Result
    {
        if(!App::getInstance()->user->isLoggedIn()) return new Redirect(Admin::COMPONENT_URL.'/login');

        $uri = str_replace('/article', '', $uri);
        if (empty($uri)) return $this->add($uri);
        return $this->change($uri);
    }

    private function add(string $uri): Result
    {
        if(!App::getInstance()->user->isMethodAllowed(__METHOD__)) {
            return new Error('Forbidden',Response::HTTP_FORBIDDEN);
        }

        $app = App::getInstance();
        if ($app->request->isMethod('POST')) {
            $title = trim(htmlspecialchars($app->request->get('title')));
            $text = $app->request->get('text');
            $url = trim(htmlspecialchars($app->request->get('url')));
            $result = $this->model->add($title, $text,$url);
            if (!empty($result)) {
                $idCategory = (int) $app->request->get('id_category');
                $this->model->setCategory($result['id'],$idCategory);

                return new Redirect(Admin::COMPONENT_URL.'/article/' . $result['id']);
            }
            return new Error('Error in creating article');
        }

        $view = new View(self::CONTROLLER_DIR . DS . 'templates' . DS . 'add.inc');

        $categoriesModel = new \Lira\Components\Admin\Category\Model(App::getInstance()->database);
        $view->categories = $categoriesModel->getList();

        $app->view->meta_title = 'Add article';
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

                $categoriesModel = new \Lira\Components\Admin\Category\Model(App::getInstance()->database);
                $view->categories = $categoriesModel->getList();

                $view->refs = $this->model->getRefCategories($id);

                if (empty($item)) return new Error('Article not found', Response::HTTP_NOT_FOUND);
                $app->view->meta_title = 'Edit article';
                return new Success($view->render());
        }
    }

    private function update(int $idArticle): Result
    {
        if(!App::getInstance()->user->isMethodAllowed(__METHOD__)) {
            return new Error('Forbidden',Response::HTTP_FORBIDDEN);
        }

        $app = App::getInstance();
        $title = trim(htmlspecialchars($app->request->get('title')));
        $url = trim(htmlspecialchars($app->request->get('url')));

        $text = $app->request->get('text');
        $this->model->update($idArticle, $title, $text,$url);
        $idCategory = (int) $app->request->get('id_category');
        $this->model->setCategory($idArticle,$idCategory);
        return new Redirect(Admin::COMPONENT_URL.'/article/' . $idArticle);
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