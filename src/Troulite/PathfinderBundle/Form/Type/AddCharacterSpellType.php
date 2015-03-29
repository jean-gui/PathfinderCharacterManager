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
use Troulite\PathfinderBundle\Form\DataTransformer\UnmanagedToManagedClassSpellTransformer;

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

        $spellTransformer = new UnmanagedToManagedClassSpellTransformer($options['em'], $options['class-definition']);
        $builder->addModelTransformer($spellTransformer);

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($em, $options) {
                /** @var $level ClassSpell */
                $classSpell = $event->getData();
                $form  = $event->getForm();
                $this->class = $classSpell->getClass();

                $learned = array_filter(
                    $options['learned'],
                    function (ClassSpell $cs) use ($classSpell) {
                        return $cs !== $classSpell;
                    }
                );

                $queryString = 'SELECT s FROM TroulitePathfinderBundle:Spell s
                            JOIN s.classes cs
                            WHERE cs.spellLevel = ?1
                                AND cs.class = ?2';
                if ($learned && count($learned) > 0) {
                    $queryString .= 'AND cs NOT IN(?3)';
                }
                $query = $em
                    ->createQuery($queryString)
                    ->setParameter(1, $classSpell->getSpellLevel())
                    ->setParameter(2, $classSpell->getClass()->getId());
                if ($learned && count($learned) > 0) {
                    $query->setParameter(3, $learned);
                }
                $spells = $query->getResult();

                $form->add(
                    'spell',
                    'entity',
                    array(
                        /** @Ignore */
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
                'data_class'       => 'Troulite\PathfinderBundle\Entity\ClassSpell'
            )
        );
        $resolver->setRequired(array('learned', 'em', 'class-definition'));
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