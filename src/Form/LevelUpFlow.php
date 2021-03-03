<?php


namespace App\Form;

use App\Entity\Characters\Level;
use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class LevelUpFlow
 *
 * @package App\Form
 */
class LevelUpFlow extends FormFlow
{
    protected $advancement;
    protected $em;

    /**
     * @param array                  $advancement
     * @param EntityManagerInterface $em
     */
    public function __construct(array $advancement, EntityManagerInterface $em)
    {
        $this->advancement = $advancement;
        $this->em = $em;
        $this->revalidatePreviousSteps = false;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'levelUp';
    }

    /**
     * {@inheritdoc}
     */
    protected function loadStepsConfig()
    {
        return array(
            array(
                'label' => 'Base',
                'type'  => LevelUpClassType::class,
            ),
            array(
                'label' => 'Subclass',
                'type'  => LevelUpSubClassType::class,
                'skip'  => function ($estimatedCurrentStepNumber, FormFlowInterface $flow) {
                    /** @var Level $level */
                    $level = $this->getFormData();
                    return !$level->getClassDefinition() || !$level->getClassDefinition()->getSubClasses()
                        || $level->getClassDefinition()->getSubClasses()->count() === 0
                        || $level->getValue() !== 1;
                }
            ),
            array(
                'label' => 'Class Summary',
                'type'  => LevelUpClassSummaryHpType::class,
            ),
            array(
                'label' => 'Feats',
                'type'  => LevelUpFeatsType::class,
            ),
            array(
                'label' => 'Spells',
                'type'  => LevelUpSpellsType::class,
            ),
            array(
                'label' => 'Skills',
                'type'  => LevelUpSkillsType::class,
            ),
            array(
                'label' => 'Confirmation',
            ),
        );
    }
}
