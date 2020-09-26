<?php

namespace App\Form;

use App\Entity\Characters\Character;
use App\Entity\Characters\CharacterFeat;
use App\Entity\Characters\Level;
use App\Entity\Rules\ClassPower;
use App\Entity\Rules\Feat;
use App\ExpressionLanguage\ExpressionLanguage;
use App\Form\Type\AddCharacterFeatType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LevelUpFeatsType
 *
 * @package App\Form
 */
class LevelUpFeatsType extends AbstractType
{
    protected $advancement;
    protected $em;

    public function __construct($advancement, EntityManagerInterface $em)
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

                $availableFeats = $em->getRepository(Feat::class)->findByAvailableFor($character);

                // Racial bonus feats
                if (
                    $character->getRace() &&
                    array_key_exists('extra_feats_per_level', $character->getRace()->getTraits())
                ) {
                    $effect = $character->getRace()->getTraits()['extra_feats_per_level'];
                    $value = (int)(new ExpressionLanguage($em))->evaluate(
                        $effect['value'],
                        array("c" => $character)
                    );
                    while ($value > 0) {
                        $choices[] = $availableFeats;
                        $featsToAdd++;
                        $value--;
                    }
                }

                $expressionLanguage = new ExpressionLanguage($em);

                // Class bonus feats
                if ($class) {
                    foreach ($level->getClassPowers() as $classPower) {
                        $power = $classPower->getClassPower();
                        $effects = $power->getEffects();
                        if ($power->hasEffects()) {
                            $ok = LevelUpFeatsType::checkPrerequisities($power, $character, $expressionLanguage);

                            if (!$ok) {
                                continue;
                            }

                            if (array_key_exists('extra_feats', $effects)) {
                                $effect = $effects['extra_feats'];
                                $value  = (int)(new ExpressionLanguage($this->em))->evaluate(
                                    $effect['value'],
                                    array("c" => $character)
                                );
                                for ($i = 0; $i < $value; $i++) {
                                    $choices[] = $availableFeats;
                                }
                                $featsToAdd += $value;
                            } elseif (array_key_exists('feat', $effects)) {
                                if ($effects['feat']['type'] === 'oneof') {
                                    /** @var QueryBuilder $qb */
                                    $qb = $em->getRepository(Feat::class)->createQueryBuilder('f');
                                    $qb
                                        ->leftJoin('f.translations', 't')
                                        ->where('t.locale = :locale')
                                        ->andWhere($qb->expr()->in('t.name', ':feats'))
                                        ->setParameter('locale', 'en')
                                        ->setParameter('feats', $effects['feat']['value'])
                                    ;

                                    $feats = $qb->getQuery()->getResult();

                                    $extraFeats = [];
                                    foreach ($feats as $key => $feat) {
                                        $extraFeats[$feat->__toString()] = $feat;
                                    }
                                    $choices[] = $extraFeats;
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
                        CollectionType::class,
                        array(
                            'entry_type' => AddCharacterFeatType::class,
                            'entry_options' => array(
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
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Level::class
        ));
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
        if (!$prerequisities) {
            $prerequisities = [];
        }

        foreach ($prerequisities as $key => $prereq) {
            if ($key === 'class-power') {
                foreach ($character->getClassPowers() as $classPower) {
                    $ok = $expressionLanguage->evaluate(
                        $prereq,
                        array("classPower" => $classPower)
                    );

                    if ($ok) {
                        return true;
                    }
                }

                return false;
            } else {
                $ok = $expressionLanguage->evaluate(
                    $prereq,
                    array("c" => $character)
                );

                if ($ok) {
                    return true;
                }
            }
        }

        return true;
    }
}
