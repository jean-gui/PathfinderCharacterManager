<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 06/07/14
 * Time: 20:13
 */

namespace Troulite\PathfinderBundle\Model;


/**
 * Class Bonus
 *
 * @package Troulite\PathfinderBundle\Model
 */
class Bonus
{
    /**
     * @var object
     */
    private $source;
    /**
     * @var int
     */
    private $value;

    /**
     * @param object $source
     * @param int $value
     */
    public function __construct($source, $value)
    {
        $this->source = $source;
        $this->value  = $value;
    }

    /**
     * @return object
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }
} 