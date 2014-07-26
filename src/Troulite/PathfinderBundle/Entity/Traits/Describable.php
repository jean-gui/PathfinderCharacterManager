<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 25/07/14
 * Time: 20:27
 */

namespace Troulite\PathfinderBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait Describable
 *
 * @package Troulite\PathfinderBundle\Entity\Traits
 */
trait Describable {
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $shortDescription;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $longDescription;

    /**
     * @param string $longDescription
     *
     * @return $this
     */
    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }

    /**
     * @param string $shortDescription
     *
     * @return $this
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }
} 