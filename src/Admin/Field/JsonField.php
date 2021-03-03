<?php

namespace App\Admin\Field;

use App\Form\Type\JsonType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

class JsonField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null)
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(JsonType::class)
            ->setTemplatePath('admin/fields/json.html.twig')
            ->addCssClass('code-json')
        ;
    }
}
