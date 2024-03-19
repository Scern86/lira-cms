<?php

declare(strict_types=1);
const DS = DIRECTORY_SEPARATOR;
define('ROOT_DIR', dirname(__FILE__));

require_once 'vendor' . DS . 'autoload.php';

use Lira\Application\Result\{Success,Error,Json,Redirect};
use Symfony\Component\HttpFoundation\{Request,Response,JsonResponse,RedirectResponse};
use \Lira\Framework\Config\{Config,PhpFile};

$logger = new \Lira\Framework\Logger\MonologAdapter();
$logger->addLogger(
    new \Monolog\Logger(
        'errors',
        [new \Monolog\Handler\StreamHandler(
            ROOT_DIR . DS . '_logs' . DS . 'error.log',
            \Monolog\Level::Warning
        )]
    )
);

$eventDispatcher = new \Lira\Framework\Events\Dispatcher();

set_error_handler(function($errno, $errstr, $errfile, $errline) use ($eventDispatcher) {
    if ($errno == E_USER_NOTICE) {
        $event = new \Lira\Application\Events\ErrorEvent('log.errors',['message'=>$errstr,'file'=>$errfile,'line'=>$errline]);
        $eventDispatcher->dispatch($event);
        return true;
    }
    return false;
});



$eventDispatcher->listen(
    'log.errors',
    function($event) use($logger){
        $logger->get('errors')->error($event->data['message'],$event->data);
    }
);

$config = new Config();
$config->set('main',new PhpFile(ROOT_DIR.DS.'config'.DS.'main.php'));
$config->set('routes',new PhpFile(ROOT_DIR.DS.'config'.DS.'routes.php'));
//$config->set('cache',new PhpFile(ROOT_DIR.DS.'config'.DS.'memcached.php'));

$router = new \Lira\Framework\Router(
    \Lira\Components\Default\Controller::class,
    $config->get('routes')->default
);

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

$dbParams = new PhpFile(ROOT_DIR.DS.'config'.DS.'database.php');
$database = new \Lira\Framework\Database\PdoAdapter(
    $dbParams->database,
    $dbParams->user,
    $dbParams->password,
    $dbParams->host,
    $dbParams->port
);

$logger->addLogger(
    new \Monolog\Logger(
        'security',
        [new \Monolog\Handler\StreamHandler(
            ROOT_DIR . DS . '_logs' . DS . 'security.log',
            \Monolog\Level::Notice
        )]
    )
);
$logger->addLogger(
    new \Monolog\Logger(
        'debug',
        [new \Monolog\Handler\StreamHandler(
            ROOT_DIR . DS . '_logs' . DS . 'debug.log',
            \Monolog\Level::Debug
        )]
    )
);

$lexicon = new \Lira\Framework\Lexicon\Lexicon(
    new \Lira\Framework\Lexicon\Lang($config->get('main')->defaultLanguage),
    $config->get('main')->languagesList
);

try{
    $app = new \Lira\Application\App(
        $router,
        $request,
        $config,
        $lexicon,
        new \Lira\Framework\Events\Dispatcher(),
        new \Lira\Application\View($lexicon)
    );
    $app->initDatabase($database);
    $app->initLogger($logger);

    $result = $app->execute($request->getPathInfo());

    $response = match ($result::class){
        Success::class,Error::class=>new Response($result->content,$result->statusCode,$result->headers),
        Json::class=>new JsonResponse($result->data,$result->statusCode,$result->headers),
        Redirect::class=>new RedirectResponse($result->url,$result->statusCode,$result->headers),
        default=>new Response('Server error',Response::HTTP_INTERNAL_SERVER_ERROR)
    };

    $response->send();
}catch (\Throwable $e){
    //$logger->get('error')->critical('Application error',[$e]);
}