<?php

namespace DemandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reponse
 * @ORM\Table()
 * @ORM\Entity
 */
class Reponse {

    public function __toString() {
        return $this->getTexte();
    }

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnvoie", type="datetime", nullable=true)
     */
    private $dateEnvoie;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Utilisateur")
     */
    private $user;

    /**
     * @var string
     * 
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $texte;

    /**
     * @ORM\ManyToOne(targetEntity="Demande")
     */
    private $demande;

    /**
     * @ORM\Column(name="fichier", type="string", length=255, nullable=true)
     */
    private $fichier;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Reponse
     */
    public function setDateEnvoie($date) {
        $this->dateEnvoie = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDateEnvoie() {
        return $this->dateEnvoie;
    }

    /**
     * Set texte
     *
     * @param string $texte
     *
     * @return Reponse
     */
    public function setTexte($texte) {
        $this->texte = $texte;

        return $this;
    }

    /**
     * Get texte
     *
     * @return string
     */
    public function getTexte() {
        return $this->texte;
    }

    /**
     * Set fichier
     *
     * @param string $fichier
     *
     * @return Reponse
     */
    public function setFichier($fichier) {
        $this->fichier = $fichier;

        return $this;
    }

    /**
     * Get fichier
     *
     * @return string
     */
    public function getFichier() {
        return $this->fichier;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\Utilisateur $user
     *
     * @return Reponse
     */
    public function setUser(\UserBundle\Entity\Utilisateur $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\Utilisateur
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set demande
     *
     * @param \DemandeBundle\Entity\Demande $demande
     *
     * @return Reponse
     */
    public function setDemande(\DemandeBundle\Entity\Demande $demande = null) {
        $this->demande = $demande;

        return $this;
    }

    /**
     * Get demande
     *
     * @return \DemandeBundle\Entity\Demande
     */
    public function getDemande() {
        return $this->demande;
    }

}
