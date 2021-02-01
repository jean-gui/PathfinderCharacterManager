<?php

namespace App\Entity\Rules;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * RaceTranslation
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Cache()
 */
class RaceTranslation implements TranslationInterface
{
    use TranslationTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank
     */
    protected $name;

    public function getId()
    {
        return $this->id;
    }

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function validate(ExecutionContextInterface $context, $payload)
    {
        if ($this->getLocale() == 'en' && !$this->getName()) {
            $context->buildViolation('You need to set at least the English name')
                    ->atPath('name')
                    ->addViolation();
        }
    }
}
