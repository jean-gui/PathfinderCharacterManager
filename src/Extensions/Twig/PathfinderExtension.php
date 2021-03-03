<?php

namespace App\Extensions\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PathfinderExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('preg_replace', [$this, 'pregReplace'])
        ];
    }

    public function pregReplace(string $subject, string $pattern, string $replacement, int $limit = -1): string
    {
        return preg_replace($pattern, $replacement, $subject, $limit);
    }
}
