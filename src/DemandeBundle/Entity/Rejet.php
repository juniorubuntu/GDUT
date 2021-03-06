<?php

namespace DemandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Entity;

/**
 * Rejet
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Rejet {

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
     * @ORM\ManyToOne(targetEntity="Demande")
     * @Assert\NotBlank()
     */
    private $demande;

    /**
     * @var text
     * 
     * @ORM\Column(type="text", length=255)
     * @Assert\NotBlank()
     */
    private $motif;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }


    /**
     * Set motif
     *
     * @param string $motif
     *
     * @return Rejet
     */
    public function setMotif($motif)
    {
        $this->motif = $motif;

        return $this;
    }

    /**
     * Get motif
     *
     * @return string
     */
    public function getMotif()
    {
        return $this->motif;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\Utilisateur $user
     *
     * @return Rejet
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
     * Set demande
     *
     * @param \DemandeBundle\Entity\Demande $demande
     *
     * @return Rejet
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
