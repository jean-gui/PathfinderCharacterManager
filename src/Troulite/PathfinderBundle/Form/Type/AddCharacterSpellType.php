<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 14/07/14
 * Time: 21:25
 */

namespace Troulite\PathfinderBundle\Form\Type;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\ClassDefinition;
use Troulite\PathfinderBundle\Entity\ClassSpell;
use Troulite\PathfinderBundle\Entity\Spell;
use Troulite\PathfinderBundle\Form\DataTransformer\SpellToClassSpellTransformer;

/**
 * Class AddCharacterSpellType
 *
 * @package Troulite\PathfinderBundle\Form\Type
 */
class AddCharacterSpellType extends AbstractType
{
    /**
     * @var ClassDefinition
     */
    private $class;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var $em EntityManager */
        $em = $options['em'];

        $spellTransformer = new SpellToClassSpellTransformer($options['em'], $options['class-definition']);
        $builder->addModelTransformer($spellTransformer);

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($em, $options) {
                /** @var $level ClassSpell */
                $classSpell = $event->getData();
                $form  = $event->getForm();

                $this->class = $classSpell->getClass();

                $spells = $em
                    ->createQuery(
                        'SELECT s FROM TroulitePathfinderBundle:Spell s
                            JOIN s.classes cs
                            WHERE cs.spellLevel = ?1
                                AND cs.class = ?2
                                AND cs NOT IN(?3)
                        '
                    )
                    ->setParameter(1, $classSpell->getSpellLevel())
                    ->setParameter(2, $classSpell->getClass()->getId())
                    ->setParameter(3, $options['learned'])
                    ->getResult();

                $form->add(
                    'spell',
                    'entity',
                    array(
                        'label'   => 'Level ' . $classSpell->getSpellLevel() . ' Spell',
                        'class'   => 'TroulitePathfinderBundle:Spell',
                        'choices' => $spells
                    )
                );
            }
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'       => 'Troulite\PathfinderBundle\Entity\ClassSpell',
                'learned'          => array(),
                'em'               => null,
                'class-definition' => null
            )
        );
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'addcharacterspell';
    }
}