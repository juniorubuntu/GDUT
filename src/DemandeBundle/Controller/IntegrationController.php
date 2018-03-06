<?php

namespace DemandeBundle\Controller;

use DemandeBundle\Entity\Integration;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Integration controller.
 *
 */
class IntegrationController extends Controller {

    /**
     * Lists all integration entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $integrations = $em->getRepository('DemandeBundle:Integration')->findAll();

        return $this->render('integration/index.html.twig', array(
                    'integrations' => $integrations,
        ));
    }

    /**
     * Creates a new integration entity.
     *
     */
    public function newAction(Request $request, $id) {
        $integration = new Integration();
        $form = $this->createForm('DemandeBundle\Form\IntegrationType', $integration);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            //On complete les infos sur le rejet
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();

            $demande = $em->getRepository('DemandeBundle:Demande')->find($id);
            $integration->setUser($user);
            $integration->setDemande($demande);
            $demande->setTraitement('2');
            $demande->setValide(true);

            $em->persist($integration);
            $em->flush();

            return $this->redirectToRoute('demande_EnCours');
        }

        return $this->render('integration/new.html.twig', array(
                    'integration' => $integration,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a integration entity.
     *
     */
    public function showAction(Integration $integration) {
        $deleteForm = $this->createDeleteForm($integration);

        return $this->render('integration/show.html.twig', array(
                    'integration' => $integration,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing integration entity.
     *
     */
    public function editAction(Request $request, Integration $integration) {
        $deleteForm = $this->createDeleteForm($integration);
        $editForm = $this->createForm('DemandeBundle\Form\IntegrationType', $integration);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('integration_edit', array('id' => $integration->getId()));
        }

        return $this->render('integration/edit.html.twig', array(
                    'integration' => $integration,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a integration entity.
     *
     */
    public function deleteAction(Request $request, Integration $integration) {
        $form = $this->createDeleteForm($integration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($integration);
            $em->flush();
        }

        return $this->redirectToRoute('integration_index');
    }

    /**
     * Creates a form to delete a integration entity.
     *
     * @param Integration $integration The integration entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Integration $integration) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('integration_delete', array('id' => $integration->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
