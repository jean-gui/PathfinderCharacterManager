<?php


namespace App\Form\DataTransformer;

use App\Entity\Rules\ClassDefinition;
use App\Entity\Rules\ClassSpell;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * Turn a non-managed ClassSpell into a managed one
 *
 * @package App\Form\DataTransformer
 */
class UnmanagedToManagedClassSpellTransformer implements DataTransformerInterface
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ClassDefinition
     */
    protected $classDefinition;

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
    public function reverseTransform($spell): ?ClassSpell
    {
        if (!$spell) {
            return null;
        }

        /** @var ClassSpell|null $classSpell */
        $classSpell = $this->em->getRepository(ClassSpell::class)->findOneBy(
            array(
                'spell' => $spell->getSpell(),
                'class' => $this->classDefinition
            )
        );
        return $classSpell;
    }
} 