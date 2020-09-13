<?php

namespace App\Model;


/**
 * Class SpellSlotBonuses
 *
 * @package App\Model
 */
class SpellSlotBonuses
{
    /**
     * @var array
     */
    private $slots;

    /**
     * Create a new AbilitiesBonuses instance
     */
    public function __construct()
    {
        $this->slots = array();
    }

    /**
     * @param $level
     * @param $value
     *
     * @return $this
     */
    public function addSlots($level, $value)
    {
        if (array_key_exists($level, $this->slots)) {
            $this->slots[$level] += $value;
        } else {
            $this->slots[$level] = $value;
        }

        return $this;
    }

    /**
     * @param $level
     *
     * @return int
     */
    public function get($level)
    {
        if (!array_key_exists($level, $this->slots)) {
            return 0;
        }
        return $this->slots[$level];
    }

} 