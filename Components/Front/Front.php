<?php

namespace Lira\Components\Front;

use Lira\Application\App;
use Lira\Framework\Results\Result;
use Lira\Application\Result\{Success,Error,Json,Redirect,InternalRedirect};
use Lira\Components\DefaultController;
use Lira\Framework\{Config\PhpFile, Controller, Router};
use Symfony\Component\HttpFoundation\Response;

class Front extends Controller
{
    const COMPONENT_DIR = ROOT_DIR . DS . 'Components' . DS . 'Front';

    public function __construct()
    {
        $app = App::getInstance();
        $app->database->init();
        $app->config->set('routes.front',new PhpFile(self::COMPONENT_DIR.DS.'routes.php'));
        $app->view->addHeaderLink('<link rel="stylesheet" href="/assets/css/style.min.css">');
        $app->view->addBodyLink('<script defer src="/assets/js/script.min.js"></script>');
    }

    public function execute(string $uri): Result
    {
        try {
            $app = App::getInstance();

            $view = $app->view;
            $view->template = self::COMPONENT_DIR.DS.'templates'.DS.'default.inc';

            $router = new Router(DefaultController::class,$app->config->get('routes.front')->default);
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