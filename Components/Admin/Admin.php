<?php

namespace Lira\Components\Admin;

use Lira\Application\App;
use Lira\Components\Front\Front;
use Lira\Framework\Results\Result;
use Lira\Application\Result\{Success,Error,Json,Redirect,InternalRedirect};
use Lira\Components\DefaultController;
use Lira\Framework\{Config\PhpFile, Controller, Router};
use Symfony\Component\HttpFoundation\Response;

class Admin extends Controller
{
    const COMPONENT_DIR = ROOT_DIR . DS . 'Components' . DS . 'Admin';

    public function __construct()
    {
        App::getInstance()->database->init();
        App::getInstance()->config->set('routes.admin',new PhpFile(self::COMPONENT_DIR.DS.'routes.php'));
    }

    public function execute(string $uri): Result
    {
        try {
            $uri = str_replace('/admin','',$uri);
            if(empty($uri)) $uri = '/';

            $app = App::getInstance();

            $view = $app->view;
            $view->template = Front::COMPONENT_DIR.DS.'templates'.DS.'default.inc';

            $router = new Router(DefaultController::class,$app->config->get('routes.admin')->default);
            $class = $router->execute($uri);
            $controller = new $class();

            $result = $controller->execute($uri);

            switch ($result::class) {
                case Success::class:
                    $view->content = $result->content;
                    return new Success($view->render(), $result->statusCode, $result->headers);
                case Error::class:
                    $view->content = $result->content;
                    return new Error($view->render(), $result->statusCode, $result->headers);
                case Json::class:
                case Redirect::class:
                case InternalRedirect::class:
                    return $result;
                default:
                    return new Error('Controller error');
            }
        } catch (\Throwable $e) {
            return new Error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}