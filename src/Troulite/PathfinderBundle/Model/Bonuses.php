<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 18/07/14
 * Time: 20:20
 */

namespace Troulite\PathfinderBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * Manage bonuses applicable to a specific character value
 *
 * @package Troulite\PathfinderBundle\Model
 */
class Bonuses {

    /**
     * @var Collection|Bonus[] List of all bonuses
     */
    private $bonuses;

    /**
     * Create a new Bonuses instance
     */
    public function __construct()
    {
        $this->bonuses = new ArrayCollection();
    }

    /**
     * Add a bonus
     *
     * @param Bonus $bonus
     *
     * @return $this
     */
    public function add(Bonus $bonus)
    {
        $this->bonuses[] = $bonus;

        return $this;
    }

    /**
     * Remove bonuses from a specific source from the list of bonuses
     *
     * @param mixed $source The source can be pretty much anything (a feat, item, simple string, ...)
     *
     * @return Collection|Bonus[]
     */
    public function remove($source)
    {
        foreach ($this->bonuses as $currentBonus) {
            if ($currentBonus->getSource() === $source) {
                $this->bonuses->remove($currentBonus);
            }
        }

        return $this->bonuses;
    }

    /**
     * Get the list of bonuses
     * @return Bonus[]
     */
    public function getBonuses()
    {
        return $this->bonuses->toArray();
    }

    /**
     * Most bonuses do not stack. This method returns the list of bonuses that can be applied to a character
     *
     * @return Bonus[]
     * @todo handle same source for non typed bonuses
     */
    public function getApplicableBonuses()
    {
        /** @var $applicable Bonus[] */
        $applicable = array();

        /**
         * Current maximum value for each bonus type
         * @var $bonusValues int[]
         */
        $bonusValues = array();

        foreach ($this->getBonuses() as $bonus) {
            $type = $bonus->getType();

            if (!$type) { // Non typed bonuses stack unless they come from the same source
                $applicable[] = $bonus;
            } elseif ($type === 'dodge') { // Dodge bonuses stack
                $applicable[] = $bonus;
            } elseif (
                !array_key_exists($type, $bonusValues) || $bonus->getValue() > $bonusValues[$type]
            ) { // Other types do not stack
                $bonusValues[$type] = $bonus->getValue();
                $applicable[] = $bonus;
            }
        }

        return $applicable;
    }

    /**
     * Get the applicable bonus value
     *
     * @return int
     */
    public function getBonus()
    {
        $finalBonus = 0;

        foreach ($this->getApplicableBonuses() as $bonus) {
            $finalBonus += $bonus->getValue();
        }
        return $finalBonus;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '' . $this->getBonus();
    }
} 