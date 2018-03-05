<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use UserBundle\Form\DroitType;
use UserBundle\Entity\Droit;

/**
 * Droit controller.
 * @Route("droit")
 *
 */
class DroitController extends Controller {

    /**
     * Lists all droit entities.
     *
     * @Route("/", name="droit")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UserBundle:Droit')->findAll();

        return $this->render('droit/index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Droit entity.
     * 
     * @Route("/new", name="droit_new")
     *
     */
    public function createAction(Request $request) {
        $entity = new Droit();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('droit_show', array('id' => $entity->getId())));
        }

        return $this->render('droit/new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Droit entity.
     *
     * @param Droit $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Droit $entity) {
        $form = $this->createForm('UserBundle\Form\DroitType', $entity, array(
            'action' => $this->generateUrl('droit_new'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));
        $form->add('submit', SubmitType::class, array('label' => 'Save', 'attr' => array('class' => ' btn btn-primary text-center col-sm-1')));

        return $form;
    }

    /**
     * Displays a form to create a new Droit entity.
     * @Route("/form_new", name="droit_newForm")
     * @Method({"GET", "POST"})
     *
     */
    public function newAction() {
        $entity = new Droit();
        $form = $this->createCreateForm($entity);

        return $this->render('droit/new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Droit entity.
     *
     * @Route("/{id}/show", name="droit_show")
     * @Method("GET")
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UserBundle:Droit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Droit entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('droit/show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Droit entity.
     *
     * @Route("/{id}/edithhh", name="droit_editbbb")
     * @Method({"GET", "POST"})
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UserBundle:Droit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Droit entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('droit/edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Droit entity.
     * 
     * @Route("/form_edit", name="droit_editForm")
     *
     * @param Droit $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Droit $entity) {
        $form = $this->createForm('UserBundle\Form\DroitType', $entity, array(
            'action' => $this->generateUrl('droit_edit', array('id' => $entity->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Modifier'));

        return $form;
    }

    /**
     * Edits an existing Droit entity.
     * 
     * @Route("/{id}/edit", name="droit_edit")
     * @Method({"GET", "POST"})
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UserBundle:Droit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Droit entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('droit_edit', array('id' => $id)));
        }

        return $this->render('droit/edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Droit entity.
     *
     * @Route("/{id}", name="droit_delete")
     * @Method("DELETE")
     * 
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UserBundle:Droit')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Droit entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('droit'));
    }

    /**
     * Creates a form to delete a Droit entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('droit_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', SubmitType::class, array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    public function attribuerDroitAction() {
        $em = $this->getDoctrine()->getManager();

        $droits = $em->getRepository('UserBundle:Droit')->findAll();
        $users = $em->getRepository('UserBundle:User')->findAll();

        return $this->render('droit/gestionDroit.html.twig', array(
                    'users' => $users,
                    'droits' => $droits
        ));
    }

    public function changeDroitAction($idUser, $idRight) {
        $em = $this->getDoctrine()->getManager();
        $droit = $em->getRepository('UserBundle:Droit')->find($idRight);
        $user = $em->getRepository('UserBundle:User')->find($idUser);
        $user->setRoles(array($droit->getRightToken()));
        $user->setLevel($droit->getNom());
        $em->persist($user);
        $em->flush();
        return $this->redirect($this->generateUrl('attribution_droit'));
    }

    public function detailDroitAction($id) {
        $em = $this->getDoctrine()->getManager();

        $droit = $em->getRepository('UserBundle:Droit')->find($id);
        return $this->render('droit/detailDroit.html.twig', array(
                    'droit' => $droit
                        )
        );
    }

}
