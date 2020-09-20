<?php

namespace App\Form;

use App\Entity\Characters\Level;
use App\Entity\Rules\SubClass;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LevelUpSubClassType
 *
 * @package App\Form
 */
class LevelUpSubClassType extends AbstractType
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $qb = $this->em->createQueryBuilder()->select('sc')->from(SubClass::class, 'sc')
            ->leftJoin('sc.translations', 't')
            ->andWhere('sc.parent = ?1')
            ->addOrderBy('t.name', 'ASC');
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
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Level::class
        ));
    }
}
