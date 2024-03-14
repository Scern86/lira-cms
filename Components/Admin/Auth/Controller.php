<?php

namespace Lira\Components\Admin\Auth;

use Lira\Application\App;
use Lira\Application\Result\Redirect;
use Lira\Application\Result\Success;
use Lira\Components\Admin\Admin;
use Lira\Framework\Results\Result;
use Lira\Framework\View;

class Controller extends \Lira\Framework\Controller
{
    const CONTROLLER_DIR = Admin::COMPONENT_DIR.DS.'Auth';

    public function __construct()
    {

    }
    public function execute(string $uri): Result
    {
        $app = App::getInstance();

        if($uri=='/logout'){
            return $this->logout();
        }

        if($app->user->isLoggedIn()) return new Redirect('/admin');

        if($app->request->isMethod('POST')){
            return $this->login();
        }else{
            return $this->showLoginPage();
        }
    }

    private function showLoginPage(): Result
    {
        App::getInstance()->view->template = self::CONTROLLER_DIR.DS.'template.inc';
        $view = new View(self::CONTROLLER_DIR.DS.'login.inc');
        App::getInstance()->view->addHeaderLink('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">');
        return new Success($view->render());
    }

    private function login(): Result
    {
        $request = App::getInstance()->request;
        $login = $request->get('login');
        $password = $request->get('password');

        if(App::getInstance()->user->login($login,$password)){
            return new Redirect('/admin');
        }
        return new Redirect('/admin/login');
    }

    private function logout(): Result
    {
        $app = App::getInstance();
        if(!$app->user->isLoggedIn()) return new Redirect('/admin/login');
        $app->user->logout();
        return new Redirect('/');
    }
}