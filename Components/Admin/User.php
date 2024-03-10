<?php

namespace Lira\Components\Admin;

use Lira\Application\App;
use Lira\Application\Models\Login;

class User extends \Lira\Framework\User
{
    protected \Lira\Application\Models\User $model;

    protected Login $loginModel;

    public \Lira\Application\Objects\User $userData;

    protected \Lira\Application\Objects\Login $loginData;

    public function __construct(protected array $permissions=[])
    {
        $this->model = new \Lira\Application\Models\User(App::getInstance()->database);
        $this->loginModel = new Login(App::getInstance()->database);
        parent::__construct($this->hasLogin());
    }

    protected function hasLogin(): bool
    {
        $app = App::getInstance();
        $loginData = $this->loginModel->checkLogin(
            $app->session->session_id,
            $app->request->getClientIp(),
            'Admin'
        );
        if ($loginData->is_active) {
            $this->loginData = $loginData;
            $this->userData = $this->model->getById($loginData->id_user);
            return true;
        }
        return false;
    }

    public function login(string $login = '', string $password = ''): bool
    {
        if ($this->model->verifyCredentials($login, $password, 'Admin')) {
            $user = $this->model->getByLogin($login);
            $app = App::getInstance();
            $this->loginModel->login(
                $app->session->session_id,
                $app->request->getClientIp(),
                $user->id,
                'Admin'
            );
            return true;
        }
        return false;
    }

    public function logout(): void
    {
        $app = App::getInstance();
        $ssid = $app->session->session_id;
        $component = 'Admin';
        $this->loginModel->logout(
            $this->loginData->id_user,
            $ssid,
            $component
        );
        App::getInstance()->session->destroy();
    }

    public function isMethodAllowed(string $method): bool
    {
        if(array_key_exists($method,$this->permissions)){
            return $this->permissions[$method];
        }
        return false;
    }
}