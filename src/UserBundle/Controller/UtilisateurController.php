<?php

namespace UserBundle\Controller;

use UserBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Utilisateur controller.
 *
 * @Route("account")
 */
class UtilisateurController extends BaseController {

    /**
     * Lists all utilisateur entities.
     *
     * @Route("/", name="utilisateur_index")
     * @Method("GET")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $utilisateurs = $em->getRepository('UserBundle:Utilisateur')->findAll();

        return $this->render('utilisateur/index.html.twig', array(
                    'utilisateurs' => $utilisateurs,
        ));
    }

    /**
     * Deletes a utilisateur entity.
     *
     * @Route("/{id}/Supprimer", name="utilisateur_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Utilisateur $utilisateur) {
        $form = $this->createDeleteForm($utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($utilisateur);
            $em->flush();
        }

        return $this->redirectToRoute('utilisateur_index');
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @Route("/new", name="enseignant_register")
     * @Method({"POST", "GET"})
     */
    public function registerAction(Request $request) {
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $em = $this->getDoctrine()->getManager();

        $user = $userManager->createUser();


        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $user->setEnabled(true);

                $user->setRoles(array($user->getLevel()->getRightToken()));

                $userManager->updateUser($user);

                $url = $this->generateUrl('utilisateur_index');
                $response = new RedirectResponse($url);

                //Flasbag message
                $request->getSession()
                        ->getFlashBag()
                        ->add('success', ' Compte Utilisateur créé avec succès');

                return $response;
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('utilisateur/new.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new utilisateur entity.
     *
     * @Route("/new", name="utilisateur_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request) {
        $utilisateur = new Utilisateur();
        $form = $this->createForm('UserBundle\Form\UtilisateurType', $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $utilisateur->setRoles(array($utilisateur->getLevel()->getRightToken()));
            $em->persist($utilisateur);
            $em->flush();

            return $this->redirectToRoute('utilisateur_show', array('id' => $utilisateur->getId()));
        }
        $form . add('dateNaissance', \Symfony\Component\Form\Extension\Core\Type\DateType::class, array(
                    'widget' => 'single_text',
                    'html5' => false));

        return $this->render('utilisateur/new.html.twig', array(
                    'utilisateur' => $utilisateur,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a utilisateur entity.
     *
     * @Route("/{id}/show", name="utilisateur_show")
     * @Method("GET")
     */
    public function showAction(Utilisateur $utilisateur) {
        $deleteForm = $this->createDeleteForm($utilisateur);

        return $this->render('utilisateur/show.html.twig', array(
                    'utilisateur' => $utilisateur,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing utilisateur entity.
     *
     * @Route("/{id}/edit", name="utilisateur_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Utilisateur $utilisateur) {
        $deleteForm = $this->createDeleteForm($utilisateur);
        $editForm = $this->createForm('UserBundle\Form\UtilisateurType', $utilisateur);
        $editForm->remove('plainPassword');
        $editForm->remove('nom');
        $editForm->remove('sexe');
        $editForm->remove('email');
        $editForm->remove('telephone');
        $editForm->remove('dateNaissance');
        $editForm->remove('lieu');
        $editForm->remove('adresse');
        $editForm->remove('cni');
        $editForm->remove('username');
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $utilisateur->setRoles(array($utilisateur->getLevel()->getRightToken()));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('utilisateur_index');
        }

        return $this->render('utilisateur/edit.html.twig', array(
                    'utilisateur' => $utilisateur,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * Displays a form to edit an existing utilisateur entity.
     *
     * @Route("/profile/{id}/edit", name="profil_edit")
     * @Method({"GET", "POST"})
     */
    public function editProfilAction(Request $request, Utilisateur $utilisateur) {
        $deleteForm = $this->createDeleteForm($utilisateur);
        $editForm = $this->createForm('UserBundle\Form\UtilisateurType', $utilisateur);
        $editForm->remove('plainPassword');
        $editForm->remove('level');
        $editForm->handleRequest($request);
        

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $utilisateur->setRoles(array($utilisateur->getLevel()->getRightToken()));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fos_user_profile_show');
        }

        return $this->render('utilisateur/edit.html.twig', array(
                    'utilisateur' => $utilisateur,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a utilisateur entity.
     *
     * @param Utilisateur $utilisateur The utilisateur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Utilisateur $utilisateur) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('utilisateur_delete', array('id' => $utilisateur->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    /**
     * this function allow a person to get a Utilisateur in a JSON Format
     * the main use of this function is for assync calls
     * @param  Request $request [description]
     * @return JSON  
     * a complexe object indicating status and the information requested
     *
     * @Route("/getUtilisateur")
     * @Method({"POST", "GET"})
     */
    public function getUtilisateur(Request $request) {

        $requestParsed = json_decode(json_encode($request->request->get('data')));
        $idUtilisateur = $requestParsed->idUtilisateur;

        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQueryBuilder()
                ->select('u')
                ->from('UserBundle:Utilisateur', 'u')
                ->where('u.id = ' . $idUtilisateur)
                ->getQuery();

        $utilisateurArray = $query->getSingleResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
        $response = [
            "message" => "Entité Utilisateur",
            "params" => $idUtilisateur,
            "status" => "success",
            "data" => json_decode(json_encode($utilisateurArray))
        ];
        return new Response(json_encode($response));
    }

    /**
     * This function is made to disable a user account.
     *
     * @Route("/{id}/disable", name="utilisateur_disable")
     * 
     */
    public function disableAction(Request $request, Utilisateur $user) {

        $user->setEnabled(false);
        $this->getDoctrine()->getManager()->flush();

        $request->getSession()
                ->getFlashBag()
                ->add('success', ' Compte Utilisateur désactivé avec succès');

        return $this->redirectToRoute('utilisateur_index');
    }

    /**
     * This function is made to enable a user account.
     *
     * @Route("/{id}/enable", name="utilisateur_enable")
     * 
     */
    public function enableAction(Request $request, Utilisateur $user) {

        $user->setEnabled(true);
        $this->getDoctrine()->getManager()->flush();

        $request->getSession()
                ->getFlashBag()
                ->add('success', 'Compte Utilisateur activé avec succès');

        return $this->redirectToRoute('utilisateur_index');
    }

}
