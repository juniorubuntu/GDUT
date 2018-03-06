<?php

namespace DemandeBundle\Controller;

use DemandeBundle\Entity\Demande;
use DemandeBundle\Entity\Rejet;
use DemandeBundle\Entity\Planif;
use DemandeBundle\Entity\Integration;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Demande controller.
 *
 */
class DemandeController extends Controller {

    /**
     * Lists all demande entities.
     *
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $userConnected = $this->getUser();

        if ($userConnected->getLevel()->getRightToken() == 'ROLE_ADMIN' || $userConnected->getLevel()->getRightToken() == 'ROLE_TRAITEUR') {
            $demandes = $em->getRepository('DemandeBundle:Demande')->findBy(array('trash' => false));
        } else if ($userConnected->getLevel()->getRightToken() == 'ROLE_DEMANDEUR') {
            $demandes = $em->getRepository('DemandeBundle:Demande')->findBy(array('user' => $userConnected));
        }
        if (isset($_GET['creation'])) {
            return $this->render('demande/index.html.twig', array(
                        'demandes' => array_reverse($demandes),
                        'creation' => 'ok'
            ));
        }

        return $this->render('demande/index.html.twig', array(
                    'demandes' => array_reverse($demandes),
        ));
    }

    /**
     * Creates a new demande entity.
     *
     */
    public function newAction(Request $request) {
        $demande = new Demande();
        $form = $this->createForm('DemandeBundle\Form\DemandeType', $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fichier = '';
            $fichier = $this->importation($fichier);
            $demande->setFichier($fichier);

            $em = $this->getDoctrine()->getManager();


            // gestion si c'est un brouillon
            $trash = $request->request->get("trash");
            $userConnected = $this->getUser();
            $demande->setUser($userConnected);
            if ($trash == '1') {
                $demande->setTrash(true);
                $em->persist($demande);
                $em->flush();
                return $this->redirectToRoute('demande_enPrepa');
            } else if ($trash == '2') {
                $date = \DateTime::createFromFormat("y-m-d h:m:s", date('y-m-d h:m:s'));
                $demande->setDateEnvoie($date);
                $demande->setTrash(false);
                $em->persist($demande);
                $em->flush();



                //  Envoie des mails
                $message = \Swift_Message::newInstance()
                        ->setFrom('juniorubuntu54@gmail.com')
                        ->setTo('juniorubuntu@gmail.com')
                        ->setSubject('Creation du ticket: GDUT#' . $demande->getLibele())
                        ->setBody('Voila ma demande');
                $this->get('mailer')->send($message);
                //->attach(Swift_Attachment::fromPath('/path/to/a/file.zip'))




                return $this->redirectToRoute('demande_index', array('creation' => 'success'));
            }
        }

        return $this->render('demande/new.html.twig', array(
                    'demande' => $demande,
                    'form' => $form->createView(),
        ));
    }

    /**
     * voir les demandes en préparation.
     *
     */
    public function enPrepaAction() {
        $em = $this->getDoctrine()->getManager();

        $demandes = $em->getRepository('DemandeBundle:Demande')->findBy(array('trash' => true));

        return $this->render('demande/enPrepas.html.twig', array(
                    'demandes' => array_reverse($demandes),
        ));
    }

    /**
     * voir sélectionner les modules d'une application.
     *
     */
    public function moduleAppAction($id) {
        $em = $this->getDoctrine()->getManager();
        $application = $em->getRepository('DemandeBundle:Application')->find($id);
        $modules = $em->getRepository('DemandeBundle:Module')->findBy(array('actif' => true, 'application' => $application));

        return $this->render('demande/moduleApp.html.twig', array(
                    'modules' => array_reverse($modules),
        ));
    }

    /**
     * Recherche d'une demande.
     *
     */
    public function searchAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $userConnected = $this->getUser();
        $demandes = $em->getRepository('DemandeBundle:Demande')->findBy(array('user' => $userConnected));
        if ($request->request->get("recherche") !== null) {
            $text = $request->request->get("recherche");

            $queryBuilder = $em->createQueryBuilder();
            $query = $queryBuilder->select('u')
                    ->from('DemandeBundle:Demande', 'u')
                    ->where('u.id like :param')
                    ->orderBy('u.id', 'ASC')
                    ->setParameters(array(
                        'param' => $text,
                    ))
                    ->getQuery();
            $demandes = $query->getResult();
            return $this->render('demande/recherche.html.twig', array(
                        'demandes' => $demandes,
                        'search' => 'search'
            ));
        }
        return $this->render('demande/recherche.html.twig');
    }

    public function importation($fichier) {
        $dossier = $this->get('kernel')->getRootDir() . '/../web/Uploads/Fichier/';
        // importation du fichier
        $fichier = basename($_FILES['fichier']['name']);
        $taille_maxi = 4000000;
        $taille = filesize($_FILES['fichier']['tmp_name']);
        $extensions = array('.rar', '.jpg', '.jpeg', '.png', '.pdf', '.docx', '.xls', '.odt', '.zip', '.tar.gz');
        $extension = strrchr($_FILES['fichier']['name'], '.');
        //Début des vérifications de sécurité...
        if (!in_array($extension, $extensions)) { //Si l'extension n'est pas dans le tableau
            $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
        }
        if ($taille > $taille_maxi) {
            $erreur = 'Le fichier est trop gros...';
        }
        if (!isset($erreur)) { //S'il n'y a pas d'erreur, on upload
            //On formate le nom du fichier ici...
            $fichier = strtr($fichier, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
            $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
            if (move_uploaded_file($_FILES['fichier']['tmp_name'], $dossier . $fichier)) { //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
                echo 'Upload effectué avec succès !';
            } else { //Sinon (la fonction renvoie FALSE).
                echo 'Echec de l\'upload !';
            }
        } else {
            echo $erreur;
        }
        return $fichier;
    }

    /**
     * Finds and displays a demande entity.
     *
     */
    public function showAction(Demande $demande) {
        //$deleteForm = $this->createDeleteForm($demande);

        $user = $this->getUser();
        //Gestion du rejet
        $rejet = new Rejet();
        $rejet->setUser($user);
        $rejet->setDemande($demande);
        $rejetForm = $this->createForm('DemandeBundle\Form\RejetType', $rejet);

        //Gestion de la planification
        $planif = new Planif();
        $planif->setUser($user);
        $planif->setDemande($demande);
        $planifForm = $this->createForm('DemandeBundle\Form\PlanifType', $planif);

        //Gestion de l'intégration projet
        $projet = new Integration();
        $projet->setUser($user);
        $projet->setDemande($demande);
        $projetForm = $this->createForm('DemandeBundle\Form\IntegrationType', $projet);

        return $this->render('demande/show.html.twig', array(
                    'demande' => $demande,
                    'form' => $rejetForm->createView(),
                    'formPlanif' => $planifForm->createView(),
                    'formProjet' => $projetForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing demande entity.
     *
     */
    public function editAction(Request $request, Demande $demande) {
        $deleteForm = $this->createDeleteForm($demande);

        //Verification si le la demande n'a pas encore de fichier
        $file = '';
        $ancien = '';
        if ($demande->getFichier() != "") {
            $ancien = $demande->getFichier();
            if (file_exists('Uploads/Fichier/' . $demande->getFichier())) {
                $file = new \Symfony\Component\HttpFoundation\File\File('Uploads/Fichier/' . $demande->getFichier());
            } else {
                $file = null;
            }
        }
        $demande->setFichier($file);
        $editForm = $this->createForm('DemandeBundle\Form\DemandeType', $demande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Suppression de l'ancien fichier
            $dossier = $this->get('kernel')->getRootDir() . '/../web/Uploads/Fichier/';
            if ($ancien != '') {
                if (basename($_FILES['fichier']['name']) == '') {
                    $demande->setFichier($ancien);
                } else {
                    if (file_exists($dossier . $ancien)) {
                        chmod($dossier . $ancien, 777);
                        unlink($dossier . $ancien);
                    }
                    $fichier = '';
                    $fichier = $this->importation($fichier);
                    $demande->setFichier($fichier);
                }
            }
            if ($ancien == '') {
                $fichier = '';
                $fichier = $this->importation($fichier);
                $demande->setFichier($fichier);
            }
            // gestion si c'est un brouillon
            $trash = $request->request->get("trash");
            if ($trash == '1') {
                $demande->setTrash(true);
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('demande_enPrepa');
            } else if ($trash == '2') {
                $date = \DateTime::createFromFormat("y-m-d h:m:s", date('y-m-d h:m:s'));
                $demande->setDateEnvoie($date);
                $demande->setTrash(false);
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('demande_index');
            }


            return $this->redirectToRoute('demande_edit', array('id' => $demande->getId()));
        }

        return $this->render('demande/edit.html.twig', array(
                    'demande' => $demande,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a demande entity.
     *
     */
    public function deleteAction(Request $request, Demande $demande) {
        $form = $this->createDeleteForm($demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($demande);
            $em->flush();
        }

        return $this->redirectToRoute('demande_index');
    }

    /**
     * Creates a form to delete a demande entity.
     *
     * @param Demande $demande The demande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Demande $demande) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('demande_delete', array('id' => $demande->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    /**
     * Affiche les demandes par application
     * 
     */
    function abandonNewAction($id) {
        $em = $this->getDoctrine()->getManager();
        $demande = new Demande();
        $demande = $em->getRepository('DemandeBundle:Demande')->find($id);
        $demande->setTraitement('3');
        $em->flush();
        return $this->redirectToRoute('demande_abandon');
    }

    /**
     * Affiche les demandes par application
     * 
     */
    public function demandeParApplAction() {
        $em = $this->getDoctrine()->getManager();

        $applications = $em->getRepository('DemandeBundle:Application')->findAll();
        foreach ($applications as $appli) {
            $demandes = $em->getRepository('DemandeBundle:Demande')->findBy(
                    array(
                        'trash' => false,
                        'application' => $appli
            ));
            $appli->setListDemandes($demandes);
        }
        return $this->render('demandePar/demandeAppl.html.twig', array(
                    'applications' => $applications
        ));
    }

    /**
     * Affiche les demandes par objet
     * 
     */
    public function demandeParObjAction() {
        $em = $this->getDoctrine()->getManager();

        $types = $em->getRepository('DemandeBundle:TypeDemande')->findAll();
        foreach ($types as $type) {
            $demandes = $em->getRepository('DemandeBundle:Demande')->findBy(
                    array(
                        'trash' => false,
                        'type' => $type
            ));
            $type->setListDemandes($demandes);
        }
        return $this->render('demandePar/demandeObjet.html.twig', array(
                    'typeDemandes' => $types
        ));
    }

    /**
     * Affiche les demandes par objet
     * 
     */
    public function demandeParUrgAction() {
        $em = $this->getDoctrine()->getManager();

        $urgences = $em->getRepository('DemandeBundle:Urgence')->findAll();
        foreach ($urgences as $urgence) {
            $demandes = $em->getRepository('DemandeBundle:Demande')->findBy(
                    array(
                        'trash' => false,
                        'niveauUrgence' => $urgence
            ));
            $urgence->setListDemandes($demandes);
        }
        return $this->render('demandePar/demandeUrg.html.twig', array(
                    'urgences' => $urgences
        ));
    }

    /**
     * Affiche les demandes non Tritées
     * 
     */
    public function demandeNonTraitAction() {
        $em = $this->getDoctrine()->getManager();

        $demandes = $em->getRepository('DemandeBundle:Demande')->findBy(
                array(
                    'trash' => false,
                    'traitement' => '0'
        ));
        return $this->render('demande/demandeNonTrait.html.twig', array(
                    'demandes' => $demandes
        ));
    }

    /**
     * Affiche les demandes Tritées
     * 
     */
    public function demandeTraitAction() {
        $em = $this->getDoctrine()->getManager();

        $demandes = $em->getRepository('DemandeBundle:Demande')->findBy(
                array(
                    'trash' => false,
                    'traitement' => '1'
        ));
        return $this->render('demande/demandeTrait.html.twig', array(
                    'demandes' => $demandes
        ));
    }

    /**
     * Affiche les demandes en cours de traitemnet
     * 
     */
    public function demandeEnCoursAction() {
        $em = $this->getDoctrine()->getManager();

        $demandes = $em->getRepository('DemandeBundle:Demande')->findBy(
                array(
                    'trash' => false,
                    'traitement' => '2'
        ));
        return $this->render('demande/demandeEnCours.html.twig', array(
                    'demandes' => array_reverse($demandes)
        ));
    }

    /**
     * Affiche les demandes rejetées
     * 
     */
    public function demandeRejeteAction() {
        $em = $this->getDoctrine()->getManager();

        $demandes = $em->getRepository('DemandeBundle:Demande')->findBy(
                array(
                    'trash' => false,
                    'valide' => false
        ));
        return $this->render('demande/demandeRejete.html.twig', array(
                    'demandes' => array_reverse($demandes)
        ));
    }

    /**
     * Affiche les demandes abandonnée
     * 
     */
    public function demandeAbandonAction() {
        $em = $this->getDoctrine()->getManager();

        $demandes = $em->getRepository('DemandeBundle:Demande')->findBy(
                array(
                    'trash' => false,
                    'traitement' => '3'
        ));
        return $this->render('demande/abandon.html.twig', array(
                    'demandes' => array_reverse($demandes)
        ));
    }

}
