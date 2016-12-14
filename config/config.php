<?php
use Silex\Application;
use Controller\CarPartController;

$app = new Application();
$app['debug'] = true;

/* Database */
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_sqlite',
        'path' => __DIR__ . '/../db/detales.db',
    ),
));

/* Dependency injection */
$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app["part.repository"] = function (Application $app) {
    return new \Repository\CarPartRepository($app['db']);
};
$app["part.controller"] = function () use ($app) {
    return new CarPartController($app['part.repository'], $app['twig'], $app['part.form']);
};

/* Views */
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => [
        __DIR__ . '/../views',
    ]
));

/* Assets */
$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.base_path' => 'assets/dist'
));
