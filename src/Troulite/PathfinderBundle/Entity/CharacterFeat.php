<?php

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CharacterFeat
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CharacterFeat
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var BaseCharacter
     *
     * @ORM\ManyToOne(targetEntity="BaseCharacter", inversedBy="feats")
     * @ORM\JoinColumn(name="character", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $character;

    /**
     * @var Feat
     *
     * @ORM\ManyToOne(targetEntity="Feat")
     * @ORM\JoinColumn(name="feat", referencedColumnName="id")
     * @Assert\NotBlank()
     */
    private $feat;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $active = false;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set character
     *
     * @param BaseCharacter $character
     *
     * @return CharacterFeat
     */
    public function setCharacter(BaseCharacter $character = null)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * Get character
     *
     * @return BaseCharacter
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Set feat
     *
     * @param Feat $feat
     *
     * @return CharacterFeat
     */
    public function setFeat(Feat $feat = null)
    {
        $this->feat = $feat;

        return $this;
    }

    /**
     * Get feat
     *
     * @return Feat
     */
    public function getFeat()
    {
        return $this->feat;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return CharacterFeat
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    public function __toString()
    {
        return $this->getFeat()->getName();
    }
}
