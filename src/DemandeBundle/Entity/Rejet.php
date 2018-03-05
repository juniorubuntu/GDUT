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

}
