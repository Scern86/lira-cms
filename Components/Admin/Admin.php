<?php

namespace Lira\Components\Admin;

use Lira\Application\App;
use Lira\Components\Front\Front;
use Lira\Framework\Results\Result;
use Lira\Application\Result\{Success,Error,Json,Redirect,InternalRedirect};
use Lira\Components\DefaultController;
use Lira\Framework\{Config\PhpFile, Controller, Router, Session};
use Symfony\Component\HttpFoundation\Response;

class Admin extends Controller
{
    const COMPONENT_DIR = ROOT_DIR . DS . 'Components' . DS . 'Admin';
    const COMPONENT_URL = '/admin';

    public function __construct()
    {
        $app = App::getInstance();
        $app->database->init();
        $app->initSession(new Session());
        $app->config->set('routes.admin',new PhpFile(self::COMPONENT_DIR.DS.'routes.php'));
        $permissions = [
            'Lira\Components\Admin\Article\Articles::list'=>true,

        ];
        $app->initUser(new User($permissions));
    }

    public function execute(string $uri): Result
    {
        try {
            $uri = str_replace(self::COMPONENT_URL,'',$uri);
            if(empty($uri)) $uri = '/';

            $app = App::getInstance();

            $view = $app->view;
            $view->template = Front::COMPONENT_DIR.DS.'templates'.DS.'default.inc';

            $router = new Router(Default\Controller::class,$app->config->get('routes.admin')->default);
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