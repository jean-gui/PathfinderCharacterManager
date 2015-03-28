<?php
namespace Troulite\PathfinderBundle\ExpressionLanguage;

use Doctrine\ORM\EntityManager;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage as BaseExpressionLanguage;
use Symfony\Component\ExpressionLanguage\ParserCache\ParserCacheInterface;

/**
 * Class ExpressionLanguage
 *
 * @package Troulite\PathfinderBundle\ExpressionLanguage
 */
class ExpressionLanguage extends BaseExpressionLanguage
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param ParserCacheInterface $cache
     * @param ExpressionFunctionProviderInterface[] $providers
     * @param EntityManager $em
     */
    public function __construct(ParserCacheInterface $cache = null, array $providers = array(), EntityManager $em = null)
    {
        parent::__construct($cache, $providers);
        $this->em = $em;
    }

    protected function registerFunctions()
    {
        parent::registerFunctions(); // do not forget to also register core functions

        /** @noinspection PhpUnusedParameterInspection */
        $this->register(
            'div',
            function ($param1, $param2) {
                return sprintf("(int) %i / %i", $param1, $param2);
            },
            function ($arguments, $param1, $param2) {
                return (int)($param1 / $param2);
            }
        );

        /** @noinspection PhpUnusedParameterInspection */
        $this->register(
            'min',
            function ($param1, $param2) {
                return sprintf("min(%f, %f)", $param1, $param2);
            },
            function ($arguments, $param1, $param2) {
                return (min($param1, $param2));
            }
        );

        /** @noinspection PhpUnusedParameterInspection */
        $this->register(
            'max',
            function ($param1, $param2) {
                return sprintf("max(%f, %f)", $param1, $param2);
            },
            function ($arguments, $param1, $param2) {
                return (max($param1, $param2));
            }
        );

        /** @noinspection PhpUnusedParameterInspection */
        $this->register(
            'skill',
            function ($param1) {
                return sprintf("if ($this->em) {
                    return $this->em->getRepository('TroulitePathfinderBundle:Skill')->findOneBy(
                        array('shortname' => %s)
                    );
                }", $param1);
            },
            function ($arguments, $param1) {
                if ($this->em) {
                    return $this->em->getRepository('TroulitePathfinderBundle:Skill')->findOneBy(
                        array('shortname' => $param1)
                    );
                }
            }
        );
    }
}