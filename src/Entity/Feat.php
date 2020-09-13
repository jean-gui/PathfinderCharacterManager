<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Entity\Traits\Power;

/**
 * Feat
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\Repository\FeatRepository")
 * @ORM\Cache()
 */
class Feat
{
    use Power;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
