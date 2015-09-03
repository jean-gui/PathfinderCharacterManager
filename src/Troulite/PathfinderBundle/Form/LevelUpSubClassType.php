<?php

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

namespace Troulite\PathfinderBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\Level;
use Troulite\PathfinderBundle\Entity\SubClass;

/**
 * Class LevelUpSubClassType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class LevelUpSubClassType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $qb = $this->em->createQueryBuilder()->select('sc')->from('TroulitePathfinderBundle:SubClass', 'sc')
            ->andWhere('sc.parent = ?1')
            ->addOrderBy('sc.name', 'ASC');
        $qb->setParameter(1, $builder->getData()->getClassDefinition()->getId());

        /** @var SubClass[] $choices */
        $choices = $qb->getQuery()->execute();
        $builder
            ->add(
                'subClasses',
                null,
                array(
                    'multiple' => true,
                    'choices'  => $choices
                )
            )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troulite\PathfinderBundle\Entity\Level'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troulite_pathfinderbundle_levelup_subclass';
    }
}
