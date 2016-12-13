<?php
namespace Controller;

use Repository\CarPartRepository;
use Symfony\Component\Form\Form;
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
     * @return string
     */
    public function indexAction()
    {
        $parts = $this->repo->fetchAll();

        return $this->twig->render('index.html.twig', array(
            'parts' => $parts,
        ));
    }

    /**
     * @param Request $request
     * @return FormView
     */
    public function newAction(Request $request)
    {
        $this->form->handleRequest($request);

        if ($this->form->isValid()) {
            $data = $this->form->getData();
            var_dump($data);
        }

        return $this->twig->render('form.html.twig', array(
            'form' => $this->form->createView(),
        ));
    }
}
