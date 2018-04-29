<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UtilisateurRepository")
 */
class Utilisateur extends BaseUser {

    public function __toString() {
        return ($this->getNom() != '') ? $this->getNom() : 'Pas de Nom';
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sexe;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cni;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $entreprise;

    /**
     * @ORM\ManyToOne(targetEntity="Droit")
     * @Assert\NotBlank()
     */
    private $level;
    private $listDemandes = [];
    private $listEnCours = [];
    private $listTermine = [];

    function getListEnCours() {
        return $this->listEnCours;
    }

    function getListTermine() {
        return $this->listTermine;
    }

    function setListEnCours($listEnCours) {
        $this->listEnCours = $listEnCours;
    }

    function setListTermine($listTermine) {
        $this->listTermine = $listTermine;
    }

    function getListDemandes() {
        return $this->listDemandes;
    }

    function setListDemandes($listDemandes) {
        $this->listDemandes = $listDemandes;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Utilisateur
     */
    public function setNom($nom) {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Utilisateur
     */
    public function setSexe($sexe) {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe() {
        return $this->sexe;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Utilisateur
     */
    public function setDateNaissance($dateNaissance) {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string
     */
    public function getLieu() {
        return $this->lieu;
    }

    /**
     * Set cni
     *
     * @param string $cni
     *
     * @return Utilisateur
     */
    public function setCni($cni) {
        $this->cni = $cni;

        return $this;
    }

    /**
     * Get cni
     *
     * @return string
     */
    public function getCni() {
        return $this->cni;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Utilisateur
     */
    public function setTelephone($telephone) {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone() {
        return $this->telephone;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Utilisateur
     */
    public function setAdresse($adresse) {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse() {
        return $this->adresse;
    }

    /**
     * Set level
     *
     * @param \UserBundle\Entity\Droit $level
     *
     * @return Utilisateur
     */
    public function setLevel(\UserBundle\Entity\Droit $level = null) {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return \UserBundle\Entity\Droit
     */
    public function getLevel() {
        return $this->level;
    }

    /**
     * Set entreprise
     *
     * @param string $entreprise
     *
     * @return Utilisateur
     */
    public function setEntreprise($entreprise) {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * Get entreprise
     *
     * @return string
     */
    public function getEntreprise() {
        return $this->entreprise;
    }

}
