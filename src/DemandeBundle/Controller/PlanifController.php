<?php

namespace DemandeBundle\Controller;

use DemandeBundle\Entity\Planif;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Planif controller.
 *
 */
class PlanifController extends Controller
{
    /**
     * Lists all planif entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $planifs = $em->getRepository('DemandeBundle:Planif')->findAll();

        return $this->render('planif/index.html.twig', array(
            'planifs' => $planifs,
        ));
    }

    /**
     * Creates a new planif entity.
     *
     */
    public function newAction(Request $request, $id)
    {
        $planif = new Planif();
        $form = $this->createForm('DemandeBundle\Form\PlanifType', $planif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($planif);
            $em->flush();

            return $this->redirectToRoute('planif_show', array('id' => $planif->getId()));
        }

        return $this->render('planif/new.html.twig', array(
            'planif' => $planif,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a planif entity.
     *
     */
    public function showAction(Planif $planif)
    {
        $deleteForm = $this->createDeleteForm($planif);

        return $this->render('planif/show.html.twig', array(
            'planif' => $planif,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing planif entity.
     *
     */
    public function editAction(Request $request, Planif $planif)
    {
        $deleteForm = $this->createDeleteForm($planif);
        $editForm = $this->createForm('DemandeBundle\Form\PlanifType', $planif);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('planif_edit', array('id' => $planif->getId()));
        }

        return $this->render('planif/edit.html.twig', array(
            'planif' => $planif,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a planif entity.
     *
     */
    public function deleteAction(Request $request, Planif $planif)
    {
        $form = $this->createDeleteForm($planif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($planif);
            $em->flush();
        }

        return $this->redirectToRoute('planif_index');
    }

    /**
     * Creates a form to delete a planif entity.
     *
     * @param Planif $planif The planif entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Planif $planif)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('planif_delete', array('id' => $planif->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
