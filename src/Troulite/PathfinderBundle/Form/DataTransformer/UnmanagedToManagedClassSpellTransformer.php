<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 14/07/14
 * Time: 21:07
 */

namespace Troulite\PathfinderBundle\Form\DataTransformer;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;
use Troulite\PathfinderBundle\Entity\ClassDefinition;
use Troulite\PathfinderBundle\Entity\ClassSpell;


/**
 * Turn a non-managed ClassSpell into a managed one
 *
 * @package Troulite\PathfinderBundle\Form\DataTransformer
 */
class UnmanagedToManagedClassSpellTransformer implements DataTransformerInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var ClassDefinition
     */
    private $classDefinition;

    /**
     * @param EntityManager $em
     * @param ClassDefinition $classDefinition
     */
    public function __construct(EntityManager $em, ClassDefinition $classDefinition)
    {
        $this->em = $em;
        $this->classDefinition = $classDefinition;
    }

    /**
     * Transforms a ClassSpell to a Spell.
     *
     * @param  ClassSpell|null $classSpell
     *
     * @return ClassSpell
     */
    public function transform($classSpell)
    {
        if (!$classSpell) {
            return null;
        }

        return $classSpell;
    }

    /**
     * Transforms a Spell to an existing ClassSpell.
     *
     * @param ClassSpell $spell
     *
     * @return ClassSpell|null
     */
    public function reverseTransform($spell)
    {
        if (!$spell) {
            return null;
        }

        $classSpell = $this->em->getRepository('TroulitePathfinderBundle:ClassSpell')->findOneBy(
            array(
                'spell' => $spell->getSpell(),
                'class' => $this->classDefinition
            )
        );
        return $classSpell;
    }
} 