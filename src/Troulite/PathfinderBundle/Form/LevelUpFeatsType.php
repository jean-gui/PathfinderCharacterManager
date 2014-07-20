<?php

namespace Troulite\PathfinderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\CharacterFeat;
use Troulite\PathfinderBundle\Entity\Level;
use Troulite\PathfinderBundle\ExpressionLanguage\ExpressionLanguage;
use Troulite\PathfinderBundle\Model\Character;
use Troulite\PathfinderBundle\Repository\FeatRepository;

/**
 * Class LevelUpFeatsType
 *
 * @package Troulite\PathfinderBundle\Form
 */
class LevelUpFeatsType extends AbstractType
{
    /**
     * @var
     */
    private $advancement;

    /**
     * @param $advancement
     */
    public function __construct($advancement)
    {
        $this->advancement = $advancement;
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
                /** @var $level Level */
                $level = $event->getData();
                $baseCharacter = $level->getCharacter();
                $character = new Character($baseCharacter);
                $class = $level->getClassDefinition();
                $form  = $event->getForm();

                $featsToAdd = -$level->getFeats()->count();

                // Racial bonus feats
                if (
                    $baseCharacter->getRace() &&
                    array_key_exists('extra_feats_per_level', $baseCharacter->getRace()->getTraits())
                ) {
                    $effect = $baseCharacter->getRace()->getTraits()['extra_feats_per_level'];
                    $value = (int)(new ExpressionLanguage())->evaluate(
                        $effect['value'],
                        array("c" => $baseCharacter)
                    );
                    while ($value > 0) {
                        $featsToAdd++;
                        $value--;
                    }
                }

                // Class bonus feats
                if (
                    $class && $class->getSpecials() &&
                    array_key_exists($character->getLevel($class), $class->getSpecials()) &&
                    array_key_exists('extra_feats', $class->getSpecials()[$character->getLevel($class)])
                ) {
                    $effect = $class->getSpecials()[$character->getLevel($class)]['extra_feats'];
                    $value  = (int)(new ExpressionLanguage())->evaluate(
                        $effect['value'],
                        array("c" => $baseCharacter)
                    );

                    while ($value > 0) {
                        $featsToAdd++;
                        $value--;
                    }
                }

                // Extra feat
                if (
                    $level &&
                    $character->getLevel() > 0 &&
                    $this->advancement[$character->getLevel()]['feat']
                ) {
                    $featsToAdd++;
                }

                while ($featsToAdd > 0) {
                    $level->addFeat(new CharacterFeat());
                    $featsToAdd--;
                }

                if ($level->getFeats()->count() > 0) {
                    $form->add(
                        'feats',
                        'collection',
                        array(
                            'label' => 'New Feat',
                            'type' => 'addcharacterfeat',
                            'options' => array(
                                'class' => 'TroulitePathfinderBundle:Feat',
                                'query_builder' => function (FeatRepository $er) use ($baseCharacter) {
                                        return $er->queryAvailableFor($baseCharacter);
                                },
                                'label' => false,
                                'required' => false,
                                'level' => $level
                            )
                        )
                    );
                }
            }
        );
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
        return 'troulite_pathfinderbundle_level';
    }
}
