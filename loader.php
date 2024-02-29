<?php

declare(strict_types=1);
const DS = DIRECTORY_SEPARATOR;
define('ROOT_DIR', dirname(dirname(__FILE__)));
define('CONFIG_DIR',ROOT_DIR.DS.'config');
define('LOG_DIR',ROOT_DIR.DS.'_logs');

require_once 'vendor' . DS . 'autoload.php';

use Lira\Application\Result\{Success,Error,Json,Redirect};
use Symfony\Component\HttpFoundation\{Request,Response,JsonResponse,RedirectResponse};
use \Lira\Framework\Config\{Config,PhpFile};

$config = new Config();
$config->set('main',new PhpFile(CONFIG_DIR.DS.'main.php'));
$config->set('routes',new PhpFile(CONFIG_DIR.DS.'routes.php'));

$eventDispatcher = new \Lira\Framework\Events\Dispatcher();
$router = new \Lira\Framework\Router(
    \Lira\Components\DefaultController::class,
    $config->get('routes')->main
);

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

$dbParams = new \Lira\Framework\Config\PhpFile(ROOT_DIR.DS.'config'.DS.'database.php');
$database = new \Lira\Application\Pdo($dbParams->database,$dbParams->user,$dbParams->password,$dbParams->host,$dbParams->port);

$cacheParams = new \Lira\Framework\Config\PhpFile(ROOT_DIR.DS.'config'.DS.'memcached.php');
$cache = new \Lira\Application\Cache($cacheParams->host,$cacheParams->port);

$logger = new \Lira\Application\Logger();
$logger->addLogger(new \Monolog\Logger('error',[new \Monolog\Handler\StreamHandler(ROOT_DIR.DS.'_logs'.DS.'error.log',\Monolog\Level::Warning)]));

$lexicon = new \Lira\Framework\Lexicon\Lexicon(
    new \Lira\Framework\Lexicon\Lang('en'),
    $config->get('main')->languagesList
);

try{
    $app = new \Lira\Application\App(
        $router,
        $request,
        $config,
        $lexicon,
        new \Lira\Application\Pdo('database','user','password'),
        $eventDispatcher,
        new \Lira\Framework\Session(),
        $cache,
        $logger,
        new \Lira\Application\View($lexicon)
    );
    $result = $app->execute($request->getPathInfo());

    $response = match ($result::class){
        Success::class,Error::class=>new Response($result->content,$result->statusCode,$result->headers),
        Json::class=>new JsonResponse($result->data,$result->statusCode,$result->headers),
        Redirect::class=>new RedirectResponse($result->url,$result->statusCode,$result->headers),
        default=>new Response('Server error',Response::HTTP_INTERNAL_SERVER_ERROR)
    };

    $response->send();
}catch (\Throwable $e){
    var_dump($e);
}

