<?php

namespace App\Entity\Items;

use App\Entity\Traits\PowerTrait;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;

/**
 * Class ItemPower
 *
 * @ORM\Entity()
 * @ORM\InheritanceType(value="SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type")
 * @ORM\DiscriminatorMap({
 *     "item"      = ItemPower::class,
 *     "equipment" = EquipmentPower::class
 * })
 * @ORM\Cache()
 *
 * @package App\Entity
 */
class ItemPower implements TranslatableInterface
{
    use TranslatableTrait;
    use PowerTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function __get($name)
    {
        $method    = 'get' . ucfirst($name);
        $arguments = [];

        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }

    public function __isset($name)
    {
        return in_array($name, ['name', 'shortDescription', 'longDescription']);
    }

    public function __toString(): string
    {
        return $this->__get('name');
    }
} 