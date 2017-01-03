<?php

namespace Controller;

use Silex\Application;
use Repository\CarTypeRepository;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CarModelController
 * @package Controller
 */
class CarTypeController
{
    /**
     * Base path for redirecting.
     */
    const BASE_PATH = '/index.php/admin/types';
    /**
     * @var CarTypeRepository
     */
    protected $repo;

    /**
     * @var \Twig_Environment
     */
    protected $twig;
    /**
     * @var Form
     */
    protected $form;

    /**
     * CarModelController constructor.
     * @param CarTypeRepository $typeRepository
     * @param \Twig_Environment $twig
     * @param Form $form
     */
    public function __construct(CarTypeRepository $typeRepository, \Twig_Environment $twig, Form $form)
    {
        $this->twig = $twig;
        $this->repo = $typeRepository;
        $this->form = $form;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function indexAction(Request $request)
    {
        $title = $request->query->has('title') ? $request->query->get('title') : '';
        $types = $this->repo->fetchByTitle($title);

        return $this->twig->render('Model/index.html.twig', array('types' => $types));
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return string
     */
    public function newAction(Application $app, Request $request)
    {
        $this->form->handleRequest($request);

        if ($this->form->isValid()) {
            $this->repo->insert($this->form->getData());

            return $app->redirect(self::BASE_PATH);
        }

        return $this->twig->render('Model/form.html.twig', array(
            'form' => $this->form->createView(),
        ));
    }

    /**
     * @param $id
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id, Application $app)
    {
        $this->repo->delete($id);

        return $app->redirect(self::BASE_PATH);
    }

    /**
     * @param $id
     * @param Application $app
     * @param Request $request
     * @return string|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction($id, Application $app, Request $request)
    {
        $this->form->handleRequest($request);

        if ($this->form->isValid()) {
            $this->repo->update($id, $this->form->getData());

            return $app->redirect(self::BASE_PATH);
        }

        $entity = $this->repo->fetchById($id);
        $this->form->setData($entity);

        return $this->twig->render('Model/form.html.twig', array(
            'form' => $this->form->createView(),
        ));
    }
}
