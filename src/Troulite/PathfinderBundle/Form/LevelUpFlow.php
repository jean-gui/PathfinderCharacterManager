<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 19/07/14
 * Time: 19:45
 */

namespace Troulite\PathfinderBundle\Form;


use Craue\FormFlowBundle\Form\FormFlow;
use Doctrine\ORM\EntityManager;

/**
 * Class LevelUpFlow
 *
 * @package Troulite\PathfinderBundle\Form
 */
class LevelUpFlow extends FormFlow
{
    /**
     * @var array
     */
    private $advancement;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param array $advancement
     * @param EntityManager $em
     */
    public function __construct($advancement, EntityManager $em)
    {
        $this->advancement = $advancement;
        $this->em = $em;
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
                'type'  => new LevelUpClassType($this->advancement),
            ),
            array(
                'label' => 'Class Summary',
                'type'  => new LevelUpClassSummaryHpType(),
            ),
            array(
                'label' => 'Feats',
                'type'  => new LevelUpFeatsType($this->advancement),
            ),
            array(
                'label' => 'Skills',
                'type'  => new LevelUpSkillsType($this->em),
            ),
            array(
                'label' => 'Confirmation',
            ),
        );
    }
} 