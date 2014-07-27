<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 29/06/14
 * Time: 18:54
 */

namespace Troulite\PathfinderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Troulite\PathfinderBundle\Entity\Traits\Describable;
use Troulite\PathfinderBundle\Entity\Traits\Power;

/**
 * SpellEffect
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SpellEffect
{
    use Power;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Character who cast the spell responsible for this effect
     *
     * @var Character|null The caster or null if it comes from an unknown source
     *
     * @ORM\ManyToOne(targetEntity="Character")
     * @ORM\JoinColumn(name="caster_id", referencedColumnName="id", nullable=true)
     */
    protected $caster;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", nullable=false)
     */
    protected $casterLevel;

    /**
     * Target character of this spell effect
     *
     * @var Character
     *
     * @ORM\ManyToOne(targetEntity="Character", inversedBy="spellEffects")
     * @ORM\JoinColumn(name="target_id", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank()
     */
    protected $target;

    /**
     * Spell that triggered this spell effect
     *
     * @var Character|null Target of the spell or null if the corresponding spell is unknown
     *
     * @ORM\ManyToOne(targetEntity="Spell")
     * @ORM\JoinColumn(name="spell_id", referencedColumnName="id", nullable=true)
     */
    protected $spell;

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
     * @return string
     */
    public function __toString()
    {
        return $this->getSpell()->getName();
    }

    /**
     * @param mixed $caster
     *
     * @return $this
     */
    public function setCaster($caster)
    {
        $this->caster = $caster;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCaster()
    {
        return $this->caster;
    }

    /**
     * @param int $casterLevel
     *
     * @return $this
     */
    public function setCasterLevel($casterLevel)
    {
        $this->casterLevel = $casterLevel;

        return $this;
    }

    /**
     * @return int
     */
    public function getCasterLevel()
    {
        return $this->casterLevel;
    }

    /**
     * @param mixed $spell
     *
     * @return $this
     */
    public function setSpell($spell)
    {
        $this->spell = $spell;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpell()
    {
        return $this->spell;
    }

    /**
     * @param mixed $target
     *
     * @return $this
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }
}
