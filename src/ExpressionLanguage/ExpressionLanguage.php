<?php

namespace App\ExpressionLanguage;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage as BaseExpressionLanguage;

class ExpressionLanguage extends BaseExpressionLanguage
{
    protected $em;

    public function __construct(
        EntityManagerInterface $em,
        CacheItemPoolInterface $cache = null,
        array $providers = []
    ) {
        $this->em = $em;

        // prepends the default provider to let users override it
        array_unshift($providers, new PathfinderExpressionLanguageProvider($this->em));

        parent::__construct($cache, $providers);
    }
}
