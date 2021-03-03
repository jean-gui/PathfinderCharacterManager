<?php


namespace App\Form;

use App\Model\CastableLevelSpells;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CastSpellsLevelType
 *
 * @package App\Form
 */
class CastSpellsLevelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'spells',
            CollectionType::class,
            array(
                'entry_type'    => CastSpellType::class,
                'entry_options' => ['targets' => $options['targets'], 'caster' => $options['caster']],
                'label'   => false,
                'required' => false
            )
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(array('caster', 'targets'));
        $resolver->setDefaults(array('data_class' => CastableLevelSpells::class));
    }
}
