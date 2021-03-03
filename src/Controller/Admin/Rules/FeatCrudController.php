<?php

namespace App\Controller\Admin\Rules;

use App\Controller\Admin\GenericCrudController;
use App\Entity\Rules\Feat;

class FeatCrudController extends GenericCrudController
{
    public static function getEntityFqcn(): string
    {
        return Feat::class;
    }
}
