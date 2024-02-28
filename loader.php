<?php

declare(strict_types=1);
const DS = DIRECTORY_SEPARATOR;
define('ROOT_DIR', dirname(dirname(__FILE__)));

require_once 'vendor' . DS . 'autoload.php';

use Lira\Application\Result\{Success,Error,Json,Redirect};
use Symfony\Component\HttpFoundation\{Request,Response,JsonResponse,RedirectResponse};

$eventDispatcher = new \Lira\Framework\Events\Dispatcher();
$router = new \Lira\Framework\Router(
    \Lira\Components\DefaultController::class,
    []
);

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

try{
    $app = new \Lira\Application\App(
        $router,
        $request,
        new \Lira\Framework\Config\Config(),
        new \Lira\Framework\Lexicon\Lexicon(
            new \Lira\Framework\Lexicon\Lang('en'),
            ['en']
        ),
        new \Lira\Application\Pdo('database','user','password'),
        new \Lira\Framework\Events\Dispatcher(),
        new \Lira\Framework\Session(),
        new \Lira\Application\Cache(),
        new \Lira\Application\Logger(),
        new \Lira\Framework\View()
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

