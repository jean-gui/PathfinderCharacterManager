<?php

namespace Troulite\PathfinderBundle\Form;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Troulite\PathfinderBundle\Entity\Character;
use Troulite\PathfinderBundle\Entity\CharacterFeat;
use Troulite\PathfinderBundle\Entity\ClassPower;
use Troulite\PathfinderBundle\Entity\Level;
use Troulite\PathfinderBundle\ExpressionLanguage\ExpressionLanguage;

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
     * @var EntityManager
     */
    private $em;

    /**
     * @param $advancement
     * @param EntityManager $em
     */
    public function __construct($advancement, EntityManager $em)
    {
        $this->advancement = $advancement;
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $this->em;
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($em) {
                /** @var $level Level */
                $level = $event->getData();
                $character = $level->getCharacter();
                $class = $level->getClassDefinition();
                $form  = $event->getForm();

                $featsToAdd = -$level->getFeats()->count();

                $choices = null;

                $availableFeats = $em->getRepository('TroulitePathfinderBundle:Feat')->findByAvailableFor($character);

                foreach ($level->getFeats() as $key => $feat) {
                    $choices[$key] = $availableFeats;
                }

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
                        $choices[] = $availableFeats;
                        $featsToAdd++;
                        $value--;
                    }
                }

                $expressionLanguage = new ExpressionLanguage();

                // Class bonus feats
                if ($class) {
                    foreach($class->getPowers() as $power) {
                        $effects = $power->getEffects();
                        if (
                            $power->getLevel() === $character->getLevel($class) &&
                            $power->hasEffects()
                        ) {
                            $ok = LevelUpFeatsType::checkPrerequisities($power, $character, $expressionLanguage);

                            if (!$ok) {
                                continue;
                            }

                            if (array_key_exists('extra_feats', $effects)) {
                                $effect = $effects['extra_feats'];
                                $value  = (int)(new ExpressionLanguage())->evaluate(
                                    $effect['value'],
                                    array("c" => $character)
                                );
                                for ($i = 0; $i < $value; $i++) {
                                    $choices[] = $availableFeats;
                                }
                                $featsToAdd += $value;
                            } elseif (array_key_exists('feat', $effects)) {
                                if ($effects['feat']['type'] === 'oneof') {
                                    $choices[] = $em->getRepository('TroulitePathfinderBundle:Feat')->findBy(
                                        array('name' => $effects['feat']['value'])
                                    );

                                    $featsToAdd += 1;
                                }
                            }
                        }
                    }
                }

                // Extra feat
                if (
                    $level &&
                    $character->getLevel() > 0 &&
                    $this->advancement[$character->getLevel()]['feat']
                ) {
                    $choices[] = $availableFeats;
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
                            'label' => 'New Feat' . ($level->getFeats()->count() > 1 ? 's' : ''),
                            'type' => 'addcharacterfeat',
                            'options' => array(
                                'label' => false,
                                'required' => false,
                                'level' => $level,
                                'choices' => $choices
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

    /**
     * @param $power
     * @param $character
     * @param $expressionLanguage
     *
     * @return bool
     */
    private static function checkPrerequisities(
        ClassPower $power,
        Character $character,
        ExpressionLanguage $expressionLanguage
    ) {
        $prerequisities = $power->getPrerequisities();

        if (array_key_exists('class-power', $prerequisities)) {
            foreach ($character->getClassPowers() as $classPower) {
                $ok = $expressionLanguage->evaluate(
                    $prerequisities['class-power'],
                    array("classPower" => $classPower)
                );

                if ($ok) {
                    return true;
                }
            }

            return false;
        }

        return true;
    }
}
