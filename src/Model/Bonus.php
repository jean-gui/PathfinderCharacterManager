<?php

namespace App\Model;


/**
 * Class Bonus
 *
 * @package App\Model
 */
class Bonus
{
    /**
     * @var object
     */
    protected $source;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var string
     */
    protected $type;

    /**
     * @param object $source
     * @param mixed  $value
     * @param null   $type
     */
    public function __construct(object $source, $value, $type = null)
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
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
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