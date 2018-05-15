<?php

namespace DemandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Urgence
 * 
 * @ORM\Table()
 * @ORM\Entity
 */
class Urgence {

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

    /**
     * @var text
     * 
     * @ORM\Column(type="text", length=255)
     * @Assert\NotBlank()
     */
    private $description;
    //garde la liste des demandes
    private $listDemandes;

    function getListDemandes() {
        return $this->listDemandes;
    }

    function setListDemandes($listDemandes) {
        $this->listDemandes = $listDemandes;
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
     * @return Urgence
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
     * Set description
     *
     * @param string $description
     *
     * @return Urgence
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

}
