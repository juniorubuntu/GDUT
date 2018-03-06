<?php

namespace DemandeBundle\Controller;

use DemandeBundle\Entity\Planif;
use UserBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Planif controller.
 *
 */
class PlanifController extends Controller {

    /**
     * Lists all planif entities.
     *
     */
    public function indexAction() {
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
    public function newAction(Request $request, $id) {
        $planif = new Planif();
        $form = $this->createForm('DemandeBundle\Form\PlanifType', $planif);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();

            //On complete les infos sur le rejet
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();

            $demande = $em->getRepository('DemandeBundle:Demande')->find($id);
            $planif->setUser($user);
            $planif->setDemande($demande);
            $demande->setTraitement('2');
            $demande->setValide(true);

            //On enregistre
            $em->persist($planif);
            $em->flush();

            return $this->redirectToRoute('demande_EnCours');
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
    public function showAction(Planif $planif) {
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
    public function editAction(Request $request, Planif $planif) {
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
    public function deleteAction(Request $request, Planif $planif) {
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
    private function createDeleteForm(Planif $planif) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('planif_delete', array('id' => $planif->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    /**
     * Voir les triateur
     * 
     */
    function traiteurAction() {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('UserBundle:Utilisateur')->findAll();
        $listUser = [];
        foreach ($users as $user) {
            if ($user->getLevel()->getRightToken() == "ROLE_TRAITEUR") {
                $listUser[] = $user;
            }
        }
        return $this->render('planif/traiteur.html.twig', array(
                    'users' => $listUser,
        ));
    }

}
