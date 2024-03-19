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
            'Lira\Components\Admin\Article\Article::add'=>true,
            'Lira\Components\Admin\Article\Article::update'=>true,
            'Lira\Components\Admin\Article\Article::delete'=>true,
            'Lira\Components\Admin\Category\Categories::list'=>true,
            'Lira\Components\Admin\Category\Category::add'=>true,
            'Lira\Components\Admin\Category\Category::update'=>true,
            'Lira\Components\Admin\Category\Category::delete'=>true,
            'Lira\Components\Admin\Messages\Messages::list'=>true,
            'Lira\Components\Admin\Messages\Message::show'=>true,
            'Lira\Components\Admin\Messages\Message::delete'=>true,

        ];
        $app->initUser(new User($permissions));
        $app->view->addBodyLink('<script defer src="https://code.jquery.com/jquery-3.7.1.min.js" 
integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>');
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
                    throw new \Exception('Controller error');
            }
        } catch (\Throwable $e) {
            //App::getInstance()->logger->get('error')->critical('Component Admin error',[$e]);
            return new Error('500 Server error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}