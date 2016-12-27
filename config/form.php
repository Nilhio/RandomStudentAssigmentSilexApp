<?php

use Constraints\Length;
use Constraints\NotBlank;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.domains' => array(),
    'locale' => false,
));

$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new FormServiceProvider());

$types = $app["type.repository"]->getArray();
$app['part.form'] = $app['form.factory']->createBuilder(FormType::class)
    ->add('title', TextType::class, [
        'label' => 'Pavadinimas',
        'constraints' => array(new NotBlank(), new Length(array('min' => 5))),
    ])
    ->add('type', ChoiceType::class, array(
        'label' => 'Markė',
        'choices' => $types,
        'constraints' => array(new NotBlank())
    ))
    ->add('price', MoneyType::class, array(
        'label'=>'Kaina',
        'constraints' => array(new NotBlank())
    ))
    ->add('qnt', IntegerType::class, array(
        'label' => 'Kiekis',
        'constraints' => array(new NotBlank())
    ))
    ->getForm();


$app['type.form'] = $app['form.factory']->createBuilder(FormType::class)
    ->add('title', TextType::class, [
        'label' => 'Pavadinimas',
        'constraints' => array(new NotBlank(), new Length(array('min' => 3))),
    ])
    ->getForm();
