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
    }
}