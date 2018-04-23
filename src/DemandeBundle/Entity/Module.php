<?php

namespace DemandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Entity;

/**
 * Module
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Module {

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

    /**
     * @var string
     * 
     * @ORM\ManyToOne(targetEntity="Application")
     * @Assert\NotBlank()
     */
    private $application;
   

    /**
     * @var text
     * 
     * @ORM\Column(type="text", length=255)
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var bool
     * 
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $actif;

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
     * @return Module
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
     * @return Module
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
     * Set actif
     *
     * @param boolean $actif
     *
     * @return Module
     */
    public function setActif($actif) {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return bool
     */
    public function getActif() {
        return $this->actif;
    }

    /**
     * Set application
     *
     * @param \DemandeBundle\Entity\Demande $application
     *
     * @return Module
     */
    public function setApplication(\DemandeBundle\Entity\Application $application = null) {
        $this->application = $application;

        return $this;
    }

    /**
     * Get application
     *
     * @return \DemandeBundle\Entity\Application
     */
    public function getApplication() {
        return $this->application;
    }

}
