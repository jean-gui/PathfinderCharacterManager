<?php

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Manage bonuses applicable to a specific character value
 *
 * @package App\Model
 */
class Bonuses
{

    /**
     * @var Collection|Bonus[] List of all bonuses
     */
    protected $bonuses;

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

            if ($bonus->getValue() == 0) {
                continue;
            }

            if (!$type) { // Non typed bonuses stack unless they come from the same source
                $applicable[] = $bonus;
            } elseif ($type === 'dodge') { // Dodge bonuses stack
                $applicable[] = $bonus;
            } elseif ($type === 'enhancement') {
                $apply = true;
                foreach ($applicable as $bonus2) {
                    if (
                        $bonus !== $bonus2 &&
                        $bonus2->getType() === 'enhancement' &&
                        $bonus2->getSource() === $bonus->getSource()
                    ) {
                        if ($bonus->getValue() < $bonus2->getValue()) {
                            $apply = false;
                        }
                    }
                }

                if ($apply) {
                    $applicable[] = $bonus;
                }
            } elseif ($type === 'armor-check-penalty') { // ACP stacks
                $applicable[] = $bonus;
            } elseif (
                !array_key_exists($type, $bonusValues) || $bonus->getValue() > $bonusValues[$type]
            ) { // Other types do not stack
                $bonusValues[$type] = $bonus->getValue();
                $applicable[$type] = $bonus;
            }
        }

        return array_values($applicable);
    }

    /**
     * Most bonuses do not stack. This method returns the list of bonuses that cannot be applied to a character
     *
     * @return Bonus[]
     * @todo handle same source for non typed bonuses
     */
    public function getNonApplicableBonuses()
    {
        // I first tried with array_udiff, but that didn't work as expected
        $nab = array();
        $ab = $this->getApplicableBonuses();
        foreach ($this->getBonuses() as $bonus) {
            if (!in_array($bonus, $ab, true)) {
                $nab[] = $bonus;
            }
        }
        return $nab;
    }

    /**
     * Get the applicable bonus value
     *
     * @param array|null $types
     *
     * @return int
     */
    public function getBonus(array $types = null)
    {
        $finalBonus = 0;
        $acp        = 0;
        $acpBonus   = 0;
        foreach ($this->getApplicableBonuses() as $bonus) {
            if ($types && !in_array($bonus->getType(), $types)) {
                continue;
            }

            if ($bonus->getType() === 'armor-check-penalty') {
                if ($bonus->getValue() < 0) {
                    $acp += $bonus->getValue();
                } else {
                    $acpBonus += $bonus->getValue();
                }
            } else {
                $finalBonus += $bonus->getValue();
            }
        }
        $finalBonus += min(0, $acp + $acpBonus);

        return $finalBonus;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return ''.$this->getBonus();
    }
}
