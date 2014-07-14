<?php
/**
 * Created by PhpStorm.
 * User: jean-gui
 * Date: 14/07/14
 * Time: 21:07
 */

namespace Troulite\PathfinderBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Troulite\PathfinderBundle\Entity\CharacterFeat;
use Troulite\PathfinderBundle\Entity\Feat;
use Troulite\PathfinderBundle\Entity\Level;


/**
 * Turn a Feat into a CharacterFeat and vice-versa
 *
 * @package Troulite\PathfinderBundle\Form\DataTransformer
 */
class FeatToCharacterFeatTransformer implements DataTransformerInterface
{
    /**
     * @var Level
     */
    private $level;

    /**
     * @param Level $level
     */
    public function __construct(Level $level)
    {
        $this->level = $level;
    }

    /**
     * Transforms a CharacterFeat to a Feat.
     *
     * @param  CharacterFeat|null $characterFeat
     *
     * @return Feat[]
     */
    public function transform($characterFeat)
    {
        if (!$characterFeat) {
            return null;
        }

        return $characterFeat->getFeat();
    }

    /**
     * Transforms a Feat to a CharacterFeat.
     *
     * @param Feat $feat
     *
     * @return CharacterFeat|null
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($feat)
    {
        if (!$feat) {
            return null;
        }

        $characterFeat = new CharacterFeat();
        $characterFeat->setLevel($this->level);
        $characterFeat->setFeat($feat);

        return $characterFeat;
    }
} 