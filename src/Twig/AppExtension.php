<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('filter_name', [$this, 'plural']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('pluralize', [$this, 'plural']),
        ];
    }

    public function plural(int $count,string $singular,?string $plural = null): string
    {
        $plural ??= $singular.'s';
        $result = $count <= 1 ? $singular : $plural;
        return "$count $result";
    }
}
