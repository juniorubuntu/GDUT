<?php

namespace DemandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Entity;

/**
 * Demande
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Demande {

    public function __construct() {
        $this->setTraitement(false);
    }

    public function __toString() {
        return $this->getLibele();
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
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $libele;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="TypeDemande")
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Module")
     * @Assert\NotBlank()
     */
    private $module;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Urgence")
     * @Assert\NotBlank()
     */
    private $niveauUrgence;

    /**
     * @var \DateTime
     */
    private $dateMiseEnExploitation;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Application")
     * @Assert\NotBlank()
     */
    private $application;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Utilisateur")
     */
    private $user;

    /**
     * @var text
     * 
     * @ORM\Column(type="text", length=255)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $personnesSupplementaires;

    /**
     * @ORM\Column(name="fichier", type="string", length=255, nullable=true)
     */
    private $fichier;

    /**
     * @var boolean
     * 
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $trash;

    /**
     * @var boolean
     * 
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $valide;

    /**
     * @var boolean
     * 
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $traitement;

    /**
     * @var boolean
     * 
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $fini;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnvoie", type="datetime", nullable=true)
     */
    private $dateEnvoie;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set libele
     *
     * @param string $libele
     *
     * @return Demande
     */
    public function setLibele($libele) {
        $this->libele = $libele;

        return $this;
    }

    /**
     * Get libele
     *
     * @return string
     */
    public function getLibele() {
        return $this->libele;
    }

    /**
     * Set type
     *
     * @param \stdClass $type
     *
     * @return Demande
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \stdClass
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set niveauUrgence
     *
     * @param \stdClass $niveauUrgence
     *
     * @return Demande
     */
    public function setNiveauUrgence($niveauUrgence) {
        $this->niveauUrgence = $niveauUrgence;

        return $this;
    }

    /**
     * Get niveauUrgence
     *
     * @return \stdClass
     */
    public function getNiveauUrgence() {
        return $this->niveauUrgence;
    }

    /**
     * Set dateMiseEnExploitation
     *
     * @param \DateTime $dateMiseEnExploitation
     *
     * @return Demande
     */
    public function setDateMiseEnExploitation($dateMiseEnExploitation) {
        $this->dateMiseEnExploitation = $dateMiseEnExploitation;

        return $this;
    }

    /**
     * Get dateMiseEnExploitation
     *
     * @return \DateTime
     */
    public function getDateMiseEnExploitation() {
        return $this->dateMiseEnExploitation;
    }

    /**
     * Set application
     *
     * @param \stdClass $application
     *
     * @return Demande
     */
    public function setApplication($application) {
        $this->application = $application;

        return $this;
    }

    /**
     * Get application
     *
     * @return \stdClass
     */
    public function getApplication() {
        return $this->application;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Demande
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set personnesSupplementaires
     *
     * @param string $personnesSupplementaires
     *
     * @return Demande
     */
    public function setPersonnesSupplementaires($personnesSupplementaires) {
        $this->personnesSupplementaires = $personnesSupplementaires;

        return $this;
    }

    /**
     * Get personnesSupplementaires
     *
     * @return string
     */
    public function getPersonnesSupplementaires() {
        return $this->personnesSupplementaires;
    }

    /**
     * Set trash
     *
     * @param boolean $trash
     *
     * @return Demande
     */
    public function setTrash($trash) {
        $this->trash = $trash;

        return $this;
    }

    /**
     * Get trash
     *
     * @return boolean
     */
    public function getTrash() {
        return $this->trash;
    }

    /**
     * Set valide
     *
     * @param boolean $valide
     *
     * @return Demande
     */
    public function setValide($valide) {
        $this->valide = $valide;

        return $this;
    }

    /**
     * Get valide
     *
     * @return boolean
     */
    public function getValide() {
        return $this->valide;
    }

    /**
     * Set traitement
     *
     * @param boolean $traitement
     *
     * @return Demande
     */
    public function setTraitement($traitement) {
        $this->traitement = $traitement;

        return $this;
    }

    /**
     * Get traitement
     *
     * @return boolean
     */
    public function getTraitement() {
        return $this->traitement;
    }

    /**
     * Set fichier
     *
     * @param string $fichier
     *
     * @return Demande
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
     * Set dateEnvoie
     *
     * @param \DateTime $dateEnvoie
     *
     * @return Demande
     */
    public function setDateEnvoie($dateEnvoie) {
        $this->dateEnvoie = $dateEnvoie;

        return $this;
    }

    /**
     * Get dateEnvoie
     *
     * @return \DateTime
     */
    public function getDateEnvoie() {
        return $this->dateEnvoie;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\Utilisateur $user
     *
     * @return Demande
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
     * Set module
     *
     * @param \DemandeBundle\Entity\Module $module
     *
     * @return Demande
     */
    public function setModule(\DemandeBundle\Entity\Module $module = null) {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return \DemandeBundle\Entity\Module
     */
    public function getModule() {
        return $this->module;
    }


    /**
     * Set fini
     *
     * @param boolean $fini
     *
     * @return Demande
     */
    public function setFini($fini)
    {
        $this->fini = $fini;

        return $this;
    }

    /**
     * Get fini
     *
     * @return boolean
     */
    public function getFini()
    {
        return $this->fini;
    }
}
