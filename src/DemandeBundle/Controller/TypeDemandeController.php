<?php

namespace DemandeBundle\Controller;

use DemandeBundle\Entity\TypeDemande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Typedemande controller.
 *
 */
class TypeDemandeController extends Controller {

    /**
     * Lists all typeDemande entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $typeDemandes = $em->getRepository('DemandeBundle:TypeDemande')->findAll();

        return $this->render('typedemande/index.html.twig', array(
                    'typeDemandes' => $typeDemandes,
        ));
    }

    /**
     * Creates a new typeDemande entity.
     *
     */
    public function newAction(Request $request) {
        $typeDemande = new Typedemande();
        $form = $this->createForm('DemandeBundle\Form\TypeDemandeType', $typeDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeDemande);
            $em->flush();

            return $this->redirectToRoute('typedemande_show', array('id' => $typeDemande->getId()));
        }

        return $this->render('typedemande/new.html.twig', array(
                    'typeDemande' => $typeDemande,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typeDemande entity.
     *
     */
    public function showAction(TypeDemande $typeDemande) {
        $deleteForm = $this->createDeleteForm($typeDemande);

        return $this->render('typedemande/show.html.twig', array(
                    'typeDemande' => $typeDemande,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeDemande entity.
     *
     */
    public function editAction(Request $request, TypeDemande $typeDemande) {
        $deleteForm = $this->createDeleteForm($typeDemande);
        $editForm = $this->createForm('DemandeBundle\Form\TypeDemandeType', $typeDemande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('typedemande_edit', array(
                        'id' => $typeDemande->getId(),
                        'modif' => 'ok'
            ));
        }

        return $this->render('typedemande/edit.html.twig', array(
                    'typeDemande' => $typeDemande,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typeDemande entity.
     *
     */
    public function deleteAction(Request $request, TypeDemande $typeDemande) {
        $form = $this->createDeleteForm($typeDemande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeDemande);
            $em->flush();
        }

        return $this->redirectToRoute('typedemande_index');
    }

    /**
     * Creates a form to delete a typeDemande entity.
     *
     * @param TypeDemande $typeDemande The typeDemande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeDemande $typeDemande) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('typedemande_delete', array('id' => $typeDemande->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
