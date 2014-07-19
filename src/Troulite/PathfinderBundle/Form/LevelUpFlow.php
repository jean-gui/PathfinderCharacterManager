<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 19/07/14
 * Time: 19:45
 */

namespace Troulite\PathfinderBundle\Form;


use Craue\FormFlowBundle\Form\FormFlow;

/**
 * Class LevelUpFlow
 *
 * @package Troulite\PathfinderBundle\Form
 */
class LevelUpFlow extends FormFlow
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
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'createVehicle';
    }

    /**
     * {@inheritdoc}
     */
    protected function loadStepsConfig()
    {
        return array(
            array(
                'label' => 'base',
                'type'  => new LevelUpClassType($this->advancement),
            ),
            array(
                'label' => 'feats',
                'type'  => new LevelUpFeatsType($this->advancement),
            ),
            array(
                'label' => 'confirmation',
            ),
        );
    }
} 