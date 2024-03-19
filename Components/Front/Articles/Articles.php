<?php

namespace Lira\Components\Front\Articles;

use Lira\Application\App;
use Lira\Application\Models\Category;
use Lira\Framework\Results\Result;
use Lira\Application\Result\{InternalRedirect, Success, Error};
use Lira\Components\Front\Front;
use Lira\Framework\View;
use Symfony\Component\HttpFoundation\Response;

class Article extends \Lira\Framework\Controller
{
    protected \Lira\Application\Models\Article $model;
    const CONTROLLER_DIR = Front::COMPONENT_DIR . DS . 'Articles';

    public function __construct()
    {
        $this->model = new \Lira\Application\Models\Article(App::getInstance()->database);
    }

    public function execute(string $uri): Result
    {
        if($uri!=='/articles') return $this->showOne($uri);
        return $this->list();
    }

    private function list(): Result
    {
        $canonicalUrl = '/articles';

        $categoryModel = new Category(App::getInstance()->database);
        $articles = $categoryModel->getArticlesByCategoryUrl($canonicalUrl);

        $view = new \Lira\Application\View(App::getInstance()->lexicon,self::CONTROLLER_DIR.DS.'template.inc');
        $view->articles = $articles;

        App::getInstance()->view->meta_title = 'Articles';

        return new Success($view->render(),Response::HTTP_OK);
    }

    private function showOne(string $url): Result
    {
        $canonicalUrl = $url;

        $article = $this->model->getArticleByUrl($canonicalUrl);
        if(empty($article)) return new InternalRedirect('/404');

        $view = new View(self::CONTROLLER_DIR.DS.'show.inc');
        $view->article = $article;

        App::getInstance()->view->meta_title = $article['title'];

        return new Success($view->render(),Response::HTTP_OK);
    }
}