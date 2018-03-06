<?php

namespace DemandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Entity;

/**
 * Planif
 * 
 * @ORM\Table()
 * @ORM\Entity
 */
class Planif {

    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Utilisateur")
     * @Assert\NotBlank()
     */
    private $user;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Utilisateur")
     * @Assert\NotBlank()
     */
    private $gerant;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Demande")
     * @Assert\NotBlank()
     */
    private $demande;

    /**
     * @var int
     * @ORM\Column(name="duree", type="integer")
     */
    private $duree;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set duree
     *
     * @param integer $duree
     *
     * @return Planif
     */
    public function setDuree($duree) {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return int
     */
    public function getDuree() {
        return $this->duree;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\Utilisateur $user
     *
     * @return Planif
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
     * Set gerant
     *
     * @param \UserBundle\Entity\Utilisateur $gerant
     *
     * @return Planif
     */
    public function setGerant(\UserBundle\Entity\Utilisateur $gerant = null) {
        $this->gerant = $gerant;

        return $this;
    }

    /**
     * Get gerant
     *
     * @return \UserBundle\Entity\Utilisateur
     */
    public function getGerant() {
        return $this->gerant;
    }

    /**
     * Set demande
     *
     * @param \DemandeBundle\Entity\Demande $demande
     *
     * @return Planif
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
