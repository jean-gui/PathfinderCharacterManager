<?php
namespace Troulite\PathfinderBundle\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage as BaseExpressionLanguage;

class ExpressionLanguage extends BaseExpressionLanguage
{
    protected function registerFunctions()
    {
        parent::registerFunctions(); // do not forget to also register core functions

        $this->register(
            'div',
            function ($param1, $param2) {
                return sprintf("(int) %i / %i", $param1, $param2);
            },
            function ($arguments, $param1, $param2) {
                return (int)($param1 / $param2);
            }
        );

        $this->register(
            'min',
            function ($param1, $param2) {
                return sprintf("min(%f, %f)", $param1, $param2);
            },
            function ($arguments, $param1, $param2) {
                return (min($param1, $param2));
            }
        );

        $this->register(
            'max',
            function ($param1, $param2) {
                return sprintf("max(%f, %f)", $param1, $param2);
            },
            function ($arguments, $param1, $param2) {
                return (max($param1, $param2));
            }
        );
    }
}