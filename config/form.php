<?php
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Validator\Constraints as Assert;

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.domains' => array(),
    'locale' => false,
));

$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new FormServiceProvider());

$app['part.form'] = $app['form.factory']->createBuilder(FormType::class)
    ->add('title', TextType::class, [
        'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
    ])
    ->add('type', ChoiceType::class, array(
        'choices' => array('BMW' => 'BMW', 'Mercedes' => 'Mercedes'),
        'constraints' => new Assert\Choice(array('Mercedes', 'BMW')),
    ))
    ->add('price', MoneyType::class)
    ->add('qnt', IntegerType::class)
    ->getForm();
