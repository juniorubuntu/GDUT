<?php

namespace DemandeBundle\Controller;

use DemandeBundle\Entity\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Application controller.
 *
 */
class ApplicationController extends Controller {

    /**
     * Lists all application entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $applications = $em->getRepository('DemandeBundle:Application')->findAll();

        foreach ($applications as $appli) {
            $modules = $em->getRepository('DemandeBundle:Module')->findBy(array(
                'application' => $appli
            ));
            $appli->setListModules($modules);
        }

        return $this->render('application/index.html.twig', array(
                    'applications' => $applications,
        ));
    }

    /**
     * Creates a new application entity.
     *
     */
    public function newAction(Request $request) {
        $application = new Application();
        $form = $this->createForm('DemandeBundle\Form\ApplicationType', $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush();

            return $this->redirectToRoute('application_show', array('id' => $application->getId()));
        }

        return $this->render('application/new.html.twig', array(
                    'application' => $application,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a application entity.
     *
     */
    public function showAction(Application $application) {
        $deleteForm = $this->createDeleteForm($application);

        return $this->render('application/show.html.twig', array(
                    'application' => $application,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing application entity.
     *
     */
    public function editAction(Request $request, Application $application) {
        $deleteForm = $this->createDeleteForm($application);
        $editForm = $this->createForm('DemandeBundle\Form\ApplicationType', $application);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('application_edit', array(
                        'id' => $application->getId(),
                        'modif' => 'ok'
            ));
        }

        return $this->render('application/edit.html.twig', array(
                    'application' => $application,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a application entity.
     *
     */
    public function deleteAction(Request $request, Application $application) {
        $form = $this->createDeleteForm($application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($application);
            $em->flush();
        }

        return $this->redirectToRoute('application_index');
    }

    /**
     * Creates a form to delete a application entity.
     *
     * @param Application $application The application entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Application $application) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('application_delete', array('id' => $application->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
