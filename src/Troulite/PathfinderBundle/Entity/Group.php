<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 29/06/14
 * Time: 01:38
 */

namespace Troulite\PathfinderBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\Group as BaseGroup;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_group")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}