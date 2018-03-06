<?php

namespace DemandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Entity;

/**
 * Integration
 * 
 * @ORM\Table()
 * @ORM\Entity
 */
class Integration {

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
    private $chefProjet;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $code;

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
     * @ORM\ManyToOne(targetEntity="Demande")
     * @Assert\NotBlank()
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
     * Set code
     *
     * @param string $code
     *
     * @return Integration
     */
    public function setCode($code) {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Set libele
     *
     * @param string $libele
     *
     * @return Integration
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
     * Set user
     *
     * @param \UserBundle\Entity\Utilisateur $user
     *
     * @return Integration
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
     * Set chefProjet
     *
     * @param \UserBundle\Entity\Utilisateur $chefProjet
     *
     * @return Integration
     */
    public function setChefProjet(\UserBundle\Entity\Utilisateur $chefProjet = null) {
        $this->chefProjet = $chefProjet;

        return $this;
    }

    /**
     * Get chefProjet
     *
     * @return \UserBundle\Entity\Utilisateur
     */
    public function getChefProjet() {
        return $this->chefProjet;
    }


    /**
     * Set demande
     *
     * @param \DemandeBundle\Entity\Demande $demande
     *
     * @return Integration
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
