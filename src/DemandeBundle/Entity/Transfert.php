<?php

namespace DemandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reponse
 * @ORM\Table()
 * @ORM\Entity
 */
class Transfert {

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
     */
    private $user;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Utilisateur")
     */
    private $gerant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateTransfert", type="datetime", nullable=true)
     */
    private $dateTransfert;

    /**
     * @ORM\ManyToOne(targetEntity="Demande")
     */
    private $demande;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }


    /**
     * Set dateTransfert
     *
     * @param \DateTime $dateTransfert
     *
     * @return Transfert
     */
    public function setDateTransfert($dateTransfert)
    {
        $this->dateTransfert = $dateTransfert;

        return $this;
    }

    /**
     * Get dateTransfert
     *
     * @return \DateTime
     */
    public function getDateTransfert()
    {
        return $this->dateTransfert;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\Utilisateur $user
     *
     * @return Transfert
     */
    public function setUser(\UserBundle\Entity\Utilisateur $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\Utilisateur
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set gerant
     *
     * @param \UserBundle\Entity\Utilisateur $gerant
     *
     * @return Transfert
     */
    public function setGerant(\UserBundle\Entity\Utilisateur $gerant = null)
    {
        $this->gerant = $gerant;

        return $this;
    }

    /**
     * Get gerant
     *
     * @return \UserBundle\Entity\Utilisateur
     */
    public function getGerant()
    {
        return $this->gerant;
    }

    /**
     * Set demande
     *
     * @param \DemandeBundle\Entity\Demande $demande
     *
     * @return Transfert
     */
    public function setDemande(\DemandeBundle\Entity\Demande $demande = null)
    {
        $this->demande = $demande;

        return $this;
    }

    /**
     * Get demande
     *
     * @return \DemandeBundle\Entity\Demande
     */
    public function getDemande()
    {
        return $this->demande;
    }
}
