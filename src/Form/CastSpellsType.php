<?php


namespace App\Form;

use App\Entity\Characters\Character;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CastSpellsType
 *
 * @package App\Form
 */
class CastSpellsType extends AbstractType
{
    /**
     * @var array
     */
    protected $extra_spells;

    /**
     * @param array $extra_spells
     */
    public function __construct($extra_spells)
    {
        $this->extra_spells = $extra_spells;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                /** @var $character Character */
                $character = $event->getData();
                $form = $event->getForm();
                $targets = array('Other' => 'other', 'Allies' => 'allies');
                if ($character->getParty()) {
                    foreach ($character->getParty()->getCharacters() as $ally) {
                        $targets[$ally->getName()] = $ally->getId();
                    }
                }

                $form->add(
                    'castable_spells_by_class_by_spell_level',
                    CollectionType::class,
                    array(
                        'label'   => false,
                        'entry_type'    => CastableClassSpellsType::class,
                        'entry_options' => array(
                            'caster'  => $character,
                            'targets' => $targets,
                            'attr' => array('class' => 'row')
                        ),
                        'required' => false
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
                'data_class' => Character::class
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['extra_spells'] = $this->extra_spells;
        $view->vars['horizontal'] = false;
    }
}
