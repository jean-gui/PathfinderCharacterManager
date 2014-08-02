<?php

namespace Troulite\PathfinderBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\ClassSpell;
use Troulite\PathfinderBundle\Entity\PreparedSpell;

/**
 * Class PreparedSpellType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class PreparedSpellType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($options) {
                /** @var $character PreparedSpell */
                $preparedSpell = $event->getData();
                $form          = $event->getForm();
                /** @var $em EntityManager */
                $em = $options['em'];

                $queryString = '
                    SELECT cs from TroulitePathfinderBundle:ClassSpell cs WHERE cs.class = ?1 AND cs.spellLevel = ?2
                ';
                $query = $em
                    ->createQuery($queryString)
                    ->setParameter(1, $preparedSpell->getClass())
                    ->setParameter(2, $options['preparedLevels'][(int)$form->getName()]);
                /** @var $classSpells ClassSpell[] */
                $classSpells = $query->getResult();
                $spells = array();
                foreach ($classSpells as $cs) {
                    $spells[] = $cs->getSpell();
                }

                $form->add(
                    'spell',
                    'entity',
                    array(
                        'label' => 'Level ' . $options['preparedLevels'][(int)$form->getName()] . ' Spell',
                        'class' => 'TroulitePathfinderBundle:Spell',
                        'choices' => $spells,
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
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\PreparedSpell'
        ));
        $resolver->setRequired(array('em', 'preparedLevels'));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_preparedspell';
    }
}
