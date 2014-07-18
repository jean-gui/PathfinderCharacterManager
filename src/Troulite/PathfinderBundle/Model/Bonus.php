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
     * @var string
     */
    private $type;

    /**
     * @param object $source
     * @param int $value
     * @param null $type
     */
    public function __construct($source, $value, $type = null)
    {
        $this->source = $source;
        $this->value  = $value;
        $this->type = $type;
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

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
} 