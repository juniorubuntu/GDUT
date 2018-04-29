<?php

namespace DemandeBundle\Controller;

use DemandeBundle\Entity\Transfert;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Transfert controller.
 *
 */
class TransfertController extends Controller
{
    /**
     * Lists all transfert entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $transferts = $em->getRepository('DemandeBundle:Transfert')->findAll();

        return $this->render('transfert/index.html.twig', array(
            'transferts' => $transferts,
        ));
    }

    /**
     * Creates a new transfert entity.
     *
     */
    public function newAction(Request $request)
    {
        $transfert = new Transfert();
        $form = $this->createForm('DemandeBundle\Form\TransfertType', $transfert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($transfert);
            $em->flush();

            return $this->redirectToRoute('transfert_show', array('id' => $transfert->getId()));
        }

        return $this->render('transfert/new.html.twig', array(
            'transfert' => $transfert,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a transfert entity.
     *
     */
    public function showAction(Transfert $transfert)
    {
        $deleteForm = $this->createDeleteForm($transfert);

        return $this->render('transfert/show.html.twig', array(
            'transfert' => $transfert,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing transfert entity.
     *
     */
    public function editAction(Request $request, Transfert $transfert)
    {
        $deleteForm = $this->createDeleteForm($transfert);
        $editForm = $this->createForm('DemandeBundle\Form\TransfertType', $transfert);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('transfert_edit', array('id' => $transfert->getId()));
        }

        return $this->render('transfert/edit.html.twig', array(
            'transfert' => $transfert,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a transfert entity.
     *
     */
    public function deleteAction(Request $request, Transfert $transfert)
    {
        $form = $this->createDeleteForm($transfert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($transfert);
            $em->flush();
        }

        return $this->redirectToRoute('transfert_index');
    }

    /**
     * Creates a form to delete a transfert entity.
     *
     * @param Transfert $transfert The transfert entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Transfert $transfert)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('transfert_delete', array('id' => $transfert->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
