<?php

namespace Troulite\PathfinderBundle\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
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

                $qb = $em->createQueryBuilder()->select('sp')->from('TroulitePathfinderBundle:Spell', 'sp')
                    ->join('TroulitePathfinderBundle:ClassSpell', 'cs', Join::WITH, 'sp = cs.spell')
                    ->andWhere('cs.class = ?1')
                    ->andWhere('cs.spellLevel = ?2');
                $qb->setParameter(1, $preparedSpell->getClass())
                    ->setParameter(2, $options['preparedLevels'][(int)$form->getName()]);

                $form->add(
                    'spell',
                    null,
                    array(
                        'label' => /** @Ignore */ 'Level ' . $options['preparedLevels'][(int)$form->getName()] . ' Spell',
                        'query_builder' => $qb,
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
