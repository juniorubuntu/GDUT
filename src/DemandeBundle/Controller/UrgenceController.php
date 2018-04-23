<?php

namespace DemandeBundle\Controller;

use DemandeBundle\Entity\Urgence;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Urgence controller.
 *
 */
class UrgenceController extends Controller {

    /**
     * Lists all urgence entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $urgences = $em->getRepository('DemandeBundle:Urgence')->findAll();

        return $this->render('urgence/index.html.twig', array(
                    'urgences' => $urgences,
        ));
    }

    /**
     * Creates a new urgence entity.
     *
     */
    public function newAction(Request $request) {
        $urgence = new Urgence();
        $form = $this->createForm('DemandeBundle\Form\UrgenceType', $urgence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($urgence);
            $em->flush();

            return $this->redirectToRoute('urgence_show', array('id' => $urgence->getId()));
        }

        return $this->render('urgence/new.html.twig', array(
                    'urgence' => $urgence,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a urgence entity.
     *
     */
    public function showAction(Urgence $urgence) {
        $deleteForm = $this->createDeleteForm($urgence);

        return $this->render('urgence/show.html.twig', array(
                    'urgence' => $urgence,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing urgence entity.
     *
     */
    public function editAction(Request $request, Urgence $urgence) {
        $deleteForm = $this->createDeleteForm($urgence);
        $editForm = $this->createForm('DemandeBundle\Form\UrgenceType', $urgence);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('urgence_edit', array(
                        'id' => $urgence->getId(),
                        'modif' => 'ok'
            ));
        }

        return $this->render('urgence/edit.html.twig', array(
                    'urgence' => $urgence,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a urgence entity.
     *
     */
    public function deleteAction(Request $request, Urgence $urgence) {
        $form = $this->createDeleteForm($urgence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($urgence);
            $em->flush();
        }

        return $this->redirectToRoute('urgence_index');
    }

    /**
     * Creates a form to delete a urgence entity.
     *
     * @param Urgence $urgence The urgence entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Urgence $urgence) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('urgence_delete', array('id' => $urgence->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
