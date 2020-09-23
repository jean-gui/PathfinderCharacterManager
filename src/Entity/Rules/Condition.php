<?php
namespace App\Entity\Rules;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Condition
 *
 * @ORM\Entity()
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 *
 * @package App\Entity
 */
class Condition implements TranslatableInterface
{
    use TranslatableTrait;

    /**
     * @Assert\Valid
     */
    protected $translations;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var array
     *
     * @ORM\Column(type="json", nullable=true)
     */
    protected $effects;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set effects
     *
     * @param array $effect
     *
     * @return $this
     */
    public function setEffects(array $effect)
    {
        $this->effects = $effect;

        return $this;
    }

    /**
     * Get effects
     *
     * @return string[]
     */
    public function getEffects()
    {
        return $this->effects;
    }

    /**
     * @return bool
     */
    public function hasEffects()
    {
        return count($this->getEffects()) > 0;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->__get('name');
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
} 