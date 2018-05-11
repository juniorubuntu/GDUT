<?php

namespace DemandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entreprise
 *
 * @ORM\Table()
 * @ORM\Entity
 * 
 */
class Entreprise {

    public function __toString() {
        return $this->getNom();
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
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $nom;
    private $listDemandes = [];
    private $nbrDemandes;
    private $nbrEnCours;
    private $nbrTermine;

    function getListDemandes() {
        return $this->listDemandes;
    }

    function getNbrDemandes() {
        return $this->nbrDemandes;
    }

    function getNbrEnCours() {
        return $this->nbrEnCours;
    }

    function getNbrTermine() {
        return $this->nbrTermine;
    }

    function setListDemandes($listDemandes) {
        $this->listDemandes = $listDemandes;
    }

    function setNbrDemandes($nbrDemandes) {
        $this->nbrDemandes = $nbrDemandes;
    }

    function setNbrEnCours($nbrEnCours) {
        $this->nbrEnCours = $nbrEnCours;
    }

    function setNbrTermine($nbrTermine) {
        $this->nbrTermine = $nbrTermine;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Entreprise
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

}
