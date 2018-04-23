<?php

namespace DemandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Application
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Application {

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
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $nom;
    //garde la liste des demande associées
    private $listDemandes = [];

    function getListDemandes() {
        return $this->listDemandes;
    }

    function setListDemandes($listDemandes) {
        $this->listDemandes = $listDemandes;
    }

    private $listModules = [];

    function getListModules() {
        return $this->listModules;
    }

    function setListModules($listModules) {
        $this->listModules = $listModules;
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
     * @return Application
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
