<?php

use Silex\Application;
use Controller\CarPartController;
use Controller\CarTypeController;

$app = new Application();
$app['debug'] = true;

/* Firewall */
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'admin' => array(
            'pattern' => '^/',
            'http' => true,
            'users' => array(
                'admin' => array('ROLE_ADMIN', '$2a$06$TkahVylkOwzpHIkLV1j6qOe4zF/bfcklnzp0x5Uo1feYAL21n.w06'),
            ),
        ),
    )
));

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

$app["type.repository"] = function (Application $app) {
    return new \Repository\CarTypeRepository($app['db']);
};

$app["part.controller"] = function () use ($app) {
    return new CarPartController($app['part.repository'], $app['twig'], $app['part.form']);
};

$app["type.controller"] = function () use ($app) {
    return new CarTypeController($app['type.repository'], $app['twig'], $app['type.form']);
};

/* Views */
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => [
        __DIR__ . '/../views',
    ]
));

/* Assets */
$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.base_path' => 'web/assets/dist'
));
