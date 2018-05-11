<?php

namespace DemandeBundle\Controller;

use DemandeBundle\Entity\Reponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Reponse controller.
 *
 */
class ReponseController extends Controller {

    /**
     * Lists all reponse entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $reponses = $em->getRepository('DemandeBundle:Reponse')->findAll();

        return $this->render('reponse/index.html.twig', array(
                    'reponses' => $reponses,
        ));
    }

    /**
     * Creates a new reponse entity.
     *
     */
    public function newAction(Request $request, $id) {
        $reponse = new Reponse();
        $form = $this->createForm('DemandeBundle\Form\ReponseType', $reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();

            //On complete les infos sur le Commentaire
            $fichier = '';
            $fichier = $this->importation($fichier);
            $reponse->setFichier($fichier);
            $user = $this->getUser();
            $date = \DateTime::createFromFormat("y-m-d h:m:s", date('y-m-d h:m:s'));
            $reponse->setDateEnvoie($date);
            $em = $this->getDoctrine()->getManager();
            $demande = $em->getRepository('DemandeBundle:Demande')->find($id);
            $reponse->setUser($user);
            $reponse->setDemande($demande);

            //On enregistre
            $em->persist($reponse);
            $em->flush();

            //Envoie de la reponse par mail
            //gestion de l'entête
            $attachment = \Swift_Attachment::fromPath($this->get('kernel')->getRootDir() . '/../web/images/logo.png')
                    ->setDisposition('inline');
            $attachment->getHeaders()->addTextHeader('Content-ID', '<logo>');
            $attachment->getHeaders()->addTextHeader('X-Attachment-Id', 'logo');
            //envoie
            $titre = 'Réponse au ticket: GDUT#' . $demande->getId();
            $texte = $reponse->getTexte();
            $message = \Swift_Message::newInstance()
                    ->setFrom('support@themis-it.com')
                    ->setTo(array($demande->getUser()->getEmail(), 'dev@themis-it.com', 'support@themis-it.com'))
                    ->setCharset('utf-8')
                    ->setContentType('text/html')
                    ->setSubject($titre)
                    ->setBody($this->render('mails/mailTrait.html.twig', array(
                                'contenu' => $texte,
                                'titre' => $titre
                    )))
                    ->attach($attachment)
            ;
            if ($reponse->getFichier() != '') {
                $message->attach(\Swift_Attachment::fromPath($this->get('kernel')->getRootDir() . '/../web/Uploads/Fichier/' . $reponse->getFichier()));
            }
            $this->get('mailer')->send($message);

            return $this->redirectToRoute('demande_show', array('id' => $demande->getId()));
        }

        return $this->render('reponse/new.html.twig', array(
                    'reponse' => $reponse,
                    'form' => $form->createView(),
        ));
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
     * Finds and displays a reponse entity.
     *
     */
    public function showAction(Reponse $reponse) {
        $deleteForm = $this->createDeleteForm($reponse);

        return $this->render('reponse/show.html.twig', array(
                    'reponse' => $reponse,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reponse entity.
     *
     */
    public function editAction(Request $request, Reponse $reponse) {
        $deleteForm = $this->createDeleteForm($reponse);
        $editForm = $this->createForm('DemandeBundle\Form\ReponseType', $reponse);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reponse_edit', array('id' => $reponse->getId()));
        }

        return $this->render('reponse/edit.html.twig', array(
                    'reponse' => $reponse,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reponse entity.
     *
     */
    public function deleteAction(Request $request, Reponse $reponse) {
        $form = $this->createDeleteForm($reponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reponse);
            $em->flush();
        }

        return $this->redirectToRoute('reponse_index');
    }

    /**
     * Creates a form to delete a reponse entity.
     *
     * @param Reponse $reponse The reponse entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reponse $reponse) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('reponse_delete', array('id' => $reponse->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
