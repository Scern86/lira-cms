<?php

namespace Lira\Components\Front\Index;

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
        $model = new Article(App::getInstance()->database);
        $article = $model->getArticleById(1);
        if(empty($article)) return new Error('404 not found',Response::HTTP_NOT_FOUND);

        $view = new View(self::CONTROLLER_DIR.DS.'template.inc');
        $view->article = $article;

        App::getInstance()->view->meta_title = $article['title'];

        return new Success($view->render(),Response::HTTP_OK);
    }
}