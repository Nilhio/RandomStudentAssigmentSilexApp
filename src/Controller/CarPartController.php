<?php
namespace Controller;

use Repository\CarPartRepository;
use Silex\Application;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiController
 * @package Controller
 */
class CarPartController
{
    /**
     * @var CarPartRepository
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
     * CarPartController constructor.
     * @param CarPartRepository $partRepository
     * @param \Twig_Environment $twig
     */
    public function __construct(CarPartRepository $partRepository, \Twig_Environment $twig, Form $form)
    {
        $this->twig = $twig;
        $this->repo = $partRepository;
        $this->form = $form;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function indexAction(Request $request)
    {
        $title = $request->query->has('title') ? $request->query->get('title') : '';
        $parts = $this->repo->fetchByTitle($title);

        return $this->twig->render('index.html.twig', array(
            'parts' => $parts,
            'search' => $title,
        ));
    }

    /**
     * @param Application $app
     * @param Request $request
     * @return FormView
     */
    public function newAction(Application $app, Request $request)
    {
        $this->form->handleRequest($request);

        if ($this->form->isValid()) {
            $this->repo->insert($this->form->getData());

            return $app->redirect('/');
        }

        return $this->twig->render('form.html.twig', array(
            'form' => $this->form->createView(),
        ));
    }
}
