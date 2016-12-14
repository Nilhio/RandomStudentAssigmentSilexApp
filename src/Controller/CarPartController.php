<?php
namespace Controller;

use Repository\CarPartRepository;
use Silex\Application;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

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
     * @param Form $form
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

    /**
     * @param $id
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id, Application $app)
    {
        $this->repo->delete($id);

        return $app->redirect('/');
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

            return $app->redirect('/');
        }

        $entity = $this->repo->fetchById($id);
        $this->form->setData($entity);

        return $this->twig->render('form.html.twig', array(
            'form' => $this->form->createView(),
        ));
    }

    /**
     * @return StreamedResponse
     */
    public function exportAction()
    {
        $response = new StreamedResponse(function () {

            $results = $this->repo->fetchByTitle('');
            $handle = fopen('php://output', 'r+');

            foreach ($results as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="dalys.txt"');

        return $response;
    }
}
