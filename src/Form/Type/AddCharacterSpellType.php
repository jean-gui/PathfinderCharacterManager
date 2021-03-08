<?php


namespace App\Form\Type;

use App\Entity\Rules\ClassDefinition;
use App\Entity\Rules\ClassSpell;
use App\Entity\Rules\Spell;
use App\Form\DataTransformer\UnmanagedToManagedClassSpellTransformer;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AddCharacterSpellType
 *
 * @package App\Form\Type
 */
class AddCharacterSpellType extends AbstractType
{
    /**
     * @var ClassDefinition
     */
    protected $class;

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

                $queryString = 'SELECT cs, s FROM Rules:ClassSpell cs
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
                    EntityType::class,
                    array(
                        'class'   => Spell::class,
                        'choices' => $spells,
                        'attr' => ['data-controller' => 'select2']
                    )
                );
            }
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'       => ClassSpell::class
            )
        );
        $resolver->setRequired(array('learned', 'em', 'class-definition'));
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return FormType::class;
    }
}
