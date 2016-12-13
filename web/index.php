<?php
require_once __DIR__.'/../vendor/autoload.php';

use Silex\Application;
use Controller\CarPartController;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Validator\Constraints as Assert;

$app = new Application();

$app['debug'] = true;

/* Database */
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_sqlite',
        'path'     => __DIR__.'/../db/detales.db',
    ),
));

/* Form */
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.domains' => array(),
    'locale' => false,
));

/* Routes */
$app->get("/", "part.controller:indexAction");
$app->get("/parts/new", "part.controller:newAction");
$app->post("/parts/new", "part.controller:newAction");


/* Form */
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new FormServiceProvider());
$form = $app['form.factory']->createBuilder(FormType::class)
    ->add('title', TextType::class, [
        'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
    ])
    ->add('price', MoneyType::class)
    ->add('qnt', IntegerType::class)
    ->add('type', ChoiceType::class, array(
        'choices' => array('BMW' => 'BMW', 'Mercedes' => 'Mercedes'),
        'constraints' => new Assert\Choice(array('Mercedes', 'BMW')),
    ))
    ->getForm();

/* Dependency injection */
$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app["part.repository"] = function (Application $app) {
    return new \Repository\CarPartRepository($app['db']);
};
$app["part.controller"] = function () use ($app, $form) {
    return new CarPartController($app['part.repository'], $app['twig'], $form);
};


/* Views */
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => [
        __DIR__.'/../views',
    ]
));

$app->run();
