<?php

namespace App\ExpressionLanguage;

use App\Entity\Rules\Skill;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

class PathfinderExpressionLanguageProvider implements ExpressionFunctionProviderInterface
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @inheritDoc
     */
    public function getFunctions()
    {
        return [
            new ExpressionFunction(
                'div',
                function ($param1, $param2) {
                    return sprintf("(int) %i / %i", $param1, $param2);
                },
                function ($arguments, $param1, $param2) {
                    return (int)($param1 / $param2);
                }
            ),
            ExpressionFunction::fromPhp('min'),
            ExpressionFunction::fromPhp('max'),
            new ExpressionFunction(
                'skill',
                function ($param1) {
                    return sprintf(
                        "if ($this->em) {
                    return $this->em->getRepository('" . Skill::class . "')->findOneBy(
                        ['shortname' => %s]
                    );
                }
                return null;",
                        $param1
                    );
                },
                function ($arguments, $param1) {
                    if ($this->em) {
                        return $this->em->getRepository(Skill::class)->findOneBy(
                            ['shortname' => $param1]
                        );
                    }

                    return null;
                }
            )
        ];
    }
}