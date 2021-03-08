<?php

namespace App\Form;

use App\Entity\Characters\Level;
use App\Entity\Characters\LevelSkill;
use App\Entity\Rules\Skill;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LevelUpClassType
 *
 * @package App\Form
 */
class LevelUpSkillsType extends AbstractType
{
    protected $em;

    /**
     * @var Collection|Skill[]
     */
    protected $skills;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->skills = $this->em->getRepository(Skill::class)->findAll();

        /** @var $level Level */
        $level = $options['data'];

        $skills = array();
        foreach ($level->getSkills() as $skill) {
            $skills[$skill->getSkill()->getId()] = $skill;
        }
        $level->getSkills()->clear();

        if ($level->getSkills()->count() === 0) {
            foreach ($this->skills as $skill) {
                if (array_key_exists($skill->getId(), $skills)) {
                    $level->addSkill($skills[$skill->getId()]);
                } else {
                    $level->addSkill(new LevelSkill($level, $skill));
                }
            }
        }
        $builder->add(
            'skills',
            CollectionType::class,
            array(
                'entry_type' => LevelSkillType::class,
                'attr' => array('class' => 'table table-hover table-striped table-sm table-responsive'),
                'label' => false,
                'entry_options' => array('label' => false)
            )
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Level::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['skills'] = $this->skills;
        /** @var $level Level */
        $level = $options['data'];
        $view->vars['character'] = $level->getCharacter();
    }
}
