<?php

namespace DemandeBundle\Controller;

use DemandeBundle\Entity\Rejet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Rejet controller.
 *
 */
class RejetController extends Controller {

    /**
     * Lists all rejet entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $rejets = $em->getRepository('DemandeBundle:Rejet')->findAll();

        return $this->render('rejet/index.html.twig', array(
                    'rejets' => $rejets,
        ));
    }

    /**
     * Creates a new rejet entity.
     *
     */
    public function newAction(Request $request, $id) {
        $rejet = new Rejet();
        $form = $this->createForm('DemandeBundle\Form\RejetType', $rejet);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //On complete les infos sur le rejet
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();

            $demande = $em->getRepository('DemandeBundle:Demande')->find($id);
            $rejet->setUser($user);
            $rejet->setDemande($demande);
            $demande->setTraitement(true);
            $demande->setValide(false);

            $em->persist($rejet);
            $em->flush();

            $to = $demande->getUser()->getEmail();
            $subject = 'Traitement de votre demande de code GDUT#' . $demande->getId();
            $message = 'Votre demade à été rejetée\nConnectez vous à themis-it.pro/gdutnew/web/ pour plus d\'informaion';
            mail($to, $subject, $message);

            return $this->redirectToRoute('demande_rejete');
        }

        return $this->render('rejet/new.html.twig', array(
                    'rejet' => $rejet,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a rejet entity.
     *
     */
    public function showAction(Rejet $rejet) {
        $deleteForm = $this->createDeleteForm($rejet);

        return $this->render('rejet/show.html.twig', array(
                    'rejet' => $rejet,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing rejet entity.
     *
     */
    public function editAction(Request $request, Rejet $rejet) {
        $deleteForm = $this->createDeleteForm($rejet);
        $editForm = $this->createForm('DemandeBundle\Form\RejetType', $rejet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rejet_edit', array('id' => $rejet->getId()));
        }

        return $this->render('rejet/edit.html.twig', array(
                    'rejet' => $rejet,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a rejet entity.
     *
     */
    public function deleteAction(Request $request, Rejet $rejet) {
        $form = $this->createDeleteForm($rejet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rejet);
            $em->flush();
        }

        return $this->redirectToRoute('rejet_index');
    }

    /**
     * Creates a form to delete a rejet entity.
     *
     * @param Rejet $rejet The rejet entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rejet $rejet) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('rejet_delete', array('id' => $rejet->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
