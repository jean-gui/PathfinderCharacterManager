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
                $character = $level->getCharacter();
                $class = $level->getClassDefinition();
                $form  = $event->getForm();

                $featsToAdd = -$level->getFeats()->count();

                // Racial bonus feats
                if (
                    $character->getRace() &&
                    array_key_exists('extra_feats_per_level', $character->getRace()->getTraits())
                ) {
                    $effect = $character->getRace()->getTraits()['extra_feats_per_level'];
                    $value = (int)(new ExpressionLanguage())->evaluate(
                        $effect['value'],
                        array("c" => $character)
                    );
                    while ($value > 0) {
                        $featsToAdd++;
                        $value--;
                    }
                }

                // Class bonus feats
                if ($class) {
                    foreach($class->getPowers() as $power) {
                        $effects = $power->getEffects();
                        if (
                            $power->getLevel() === $character->getLevel($class) &&
                            $power->hasEffects() &&
                            array_key_exists('extra_feats', $effects)
                        ) {
                            $effect = $effects['extra_feats'];
                            $value  = (int)(new ExpressionLanguage())->evaluate(
                                $effect['value'],
                                array("c" => $character)
                            );
                            $featsToAdd += $value;
                        }
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
                                'query_builder' => function (FeatRepository $er) use ($character) {
                                        return $er->queryAvailableFor($character);
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
