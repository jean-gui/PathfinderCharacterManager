<?php


namespace App\Form\Type;


use App\Entity\Characters\CharacterFeat;
use App\Entity\Rules\Feat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AddCharacterFeatType
 *
 * @package App\Form\Type
 */
class AddCharacterFeatType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$featTransformer = new FeatToCharacterFeatTransformer($options['level']);
        //$builder->addModelTransformer($featTransformer);

        $builder->add(
            'feat',
            EntityType::class,
            array(
                'class'   => Feat::class,
                'choices' => $options['choices'][$builder->getName()],
                'label'   => false
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'addcharacterfeat';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => CharacterFeat::class
            )
        );
        $resolver->setRequired(array('level', 'choices'));
    }


} 