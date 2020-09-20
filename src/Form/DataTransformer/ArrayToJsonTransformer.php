<?php


namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Turn an array to a JSON array
 *
 * @package App\Form\DataTransformer
 */
class ArrayToJsonTransformer implements DataTransformerInterface
{
    /**
     * Transforms an array to a JSON array.
     *
     * @param array $array
     *
     * @return string|null
     */
    public function transform($array): ?string
    {
        if (!$array) {
            return json_encode([]);
        }

        return json_encode($array, JSON_PRETTY_PRINT);
    }

    /**
     * Transforms a JSON array to an array.
     *
     * @param string $json
     *
     * @return array|null
     */
    public function reverseTransform($json): ?array
    {
        if (!$json) {
            return [];
        }

        return json_decode($json, true);
    }
} 