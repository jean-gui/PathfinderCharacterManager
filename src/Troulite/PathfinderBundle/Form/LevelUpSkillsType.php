<?php

namespace Troulite\PathfinderBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\Level;
use Troulite\PathfinderBundle\Entity\LevelSkill;
use Troulite\PathfinderBundle\Model\Character;

/**
 * Class LevelUpClassType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class LevelUpSkillsType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $em;

    private $skills;

    /**
     * @param $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->skills = $this->em->getRepository('TroulitePathfinderBundle:Skill')->findBy(
            array(),
            array('name' => 'ASC')
        );

        /** @var $level Level */
        $level = $options['data'];

        $skills = array();
        foreach ($level->getSkills() as $skill) {
            $skills[$skill->getSkill()->getId()] = $skill;
        }
        $level->getSkills()->clear();

        if ($level->getSkills()->count() === 0) {
            foreach ($this->skills as $skill) {
                if (array_key_exists($skill->getId(), $skills)) {
                    $level->addSkill($skills[$skill->getId()]);
                } else {
                    $level->addSkill(new LevelSkill($level, $skill));
                }
            }
        }
        $builder->add(
            'skills',
            'collection',
            array(
                'type' => new LevelSkillType(),
                'attr' => array('class' => 'table table-hover table-striped table-condensed table-responsive'),
                'label' => false,
                'options' => array('label' => false)
            )
        );

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                /** @var $level Level */
                $level     = $event->getData();
                $character = $level->getCharacter();
                $form      = $event->getForm();
            }
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\Level'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_level';
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['skills'] = $this->skills;
        $view->vars['character'] = new Character($options['data']->getCharacter());
    }
}
