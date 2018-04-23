<?php

namespace DemandeBundle\Controller;

use DemandeBundle\Entity\Module;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Module controller.
 *
 */
class ModuleController extends Controller {

    /**
     * Lists all module entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $modules = $em->getRepository('DemandeBundle:Module')->findAll();

        return $this->render('module/index.html.twig', array(
                    'modules' => $modules,
        ));
    }

    /**
     * Creates a new module entity.
     *
     */
    public function newAction(Request $request) {
        $module = new Module();
        $form = $this->createForm('DemandeBundle\Form\ModuleType', $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($module);
            $em->flush();

            return $this->redirectToRoute('module_show', array('id' => $module->getId()));
        }

        return $this->render('module/new.html.twig', array(
                    'module' => $module,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a module entity.
     *
     */
    public function showAction(Module $module) {
        $deleteForm = $this->createDeleteForm($module);

        return $this->render('module/show.html.twig', array(
                    'module' => $module,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing module entity.
     *
     */
    public function editAction(Request $request, Module $module) {
        $deleteForm = $this->createDeleteForm($module);
        $editForm = $this->createForm('DemandeBundle\Form\ModuleType', $module);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('module_edit', array(
                        'id' => $module->getId(),
                        'modif' => 'ok'
            ));
        }

        return $this->render('module/edit.html.twig', array(
                    'module' => $module,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a module entity.
     *
     */
    public function deleteAction(Request $request, Module $module) {
        $form = $this->createDeleteForm($module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($module);
            $em->flush();
        }

        return $this->redirectToRoute('module_index');
    }

    /**
     * Creates a form to delete a module entity.
     *
     * @param Module $module The module entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Module $module) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('module_delete', array('id' => $module->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
