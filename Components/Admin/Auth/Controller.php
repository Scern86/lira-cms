<?php

namespace Lira\Components\Admin\Auth;

use Lira\Application\App;
use Lira\Application\Result\Error;
use Lira\Application\Result\Redirect;
use Lira\Application\Result\Success;
use Lira\Components\Admin\Admin;
use Lira\Framework\Results\Result;
use Lira\Framework\View;

class Controller extends \Lira\Framework\Controller
{
    const CONTROLLER_DIR = Admin::COMPONENT_DIR.DS.'Auth';

    public function execute(string $uri): Result
    {
        $app = App::getInstance();
        if($uri=='/logout'){
            if(!$app->user->isLoggedIn()) return new Redirect(Admin::COMPONENT_URL.'/login');
            $app->user->logout();
            return new Redirect('/');
        }

        if($app->user->isLoggedIn()) return new Redirect(Admin::COMPONENT_URL);
        if($app->request->isMethod('POST')){
            $login = $app->request->get('login');
            $password = $app->request->get('password');
            if($app->user->login($login,$password)){
                return new Redirect(Admin::COMPONENT_URL);
            }
            return new Redirect(Admin::COMPONENT_URL.'/login');
        }
        $app->view->template = self::CONTROLLER_DIR.DS.'template.inc';
        $view = new View(self::CONTROLLER_DIR.DS.'login.inc');
        return new Success($view->render());
    }
}