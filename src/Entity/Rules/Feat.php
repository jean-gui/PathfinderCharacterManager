<?php

namespace App\Entity\Rules;

use App\Entity\PowerInterface;
use App\Entity\Traits\PowerTrait;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Feat
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\Repository\FeatRepository")
 */
class Feat implements PowerInterface, TranslatableInterface
{
    use PowerTrait;
    use TranslatableTrait;

    /**
     * @Assert\Valid
     */
    protected $translations;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
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
