<?php
use DI\Container;
use DI\Bridge\Slim\Bridge as SlimAppFactory;

require_once __DIR__  .'/../vendor/autoload.php';

$container = new Container();

$settings = require_once __DIR__.'/settings.php';

$settings($container);

$app = SlimAppFactory::create($container);

$middleware = require_once __DIR__ . '/middleware.php';

$middleware($app);

$routes = require_once  __DIR__ .'/routes.php';

$routes($app);

$app->run();