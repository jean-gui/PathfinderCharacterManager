<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 14/07/14
 * Time: 21:25
 */
/*
 * Copyright 2015 Jean-Guilhem Rouel
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
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

                $queryString = 'SELECT cs, s FROM TroulitePathfinderBundle:ClassSpell cs
                            JOIN cs.spell s
                            WHERE cs.class = ?2';
                if ($this->class->isAbleToLearnLowerLevelSpells()) {
                    $queryString .= 'AND cs.spellLevel <= ?1 AND cs.spellLevel > 0';
                } else {
                    $queryString .= 'AND cs.spellLevel = ?1';
                }
                if ($learned && count($learned) > 0) {
                    $queryString .= 'AND cs NOT IN(?3)';
                }
                $queryString .= ' ORDER BY cs.spellLevel DESC';
                $query = $em
                    ->createQuery($queryString)
                    ->setParameter(1, $classSpell->getSpellLevel())
                    ->setParameter(2, $classSpell->getClass()->getId());
                if ($learned && count($learned) > 0) {
                    $query->setParameter(3, $learned);
                }
                /** @var ClassSpell[] $classSpells */
                $classSpells = $query->getResult();

                $spells = array();
                foreach ($classSpells as $cs) {
                    $spells['Level ' . $cs->getSpellLevel()][] = $cs->getSpell();
                }

                $form->add(
                    'spell',
                    'entity',
                    array(
                        /** @Ignore */
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