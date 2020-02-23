<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Description of StringToArrayTransformer
 *
 * @author Radosław Skrzypczak <radoslaw.skrzypczak@pearfly.pl>
 */
final class StringToArrayTransformer implements DataTransformerInterface
{
    const TRIM_CHARACTER_MASKU = " \t\n\r\0\x0B";
    
    public function transform($value)
    {
        if (null === $value) {
            return '';
        }

        return $value;
    }
    
    public function reverseTransform($value)
    {
        if (!$value) {
            return;
        }
        
        if (null === $value) {
            return '';
        }
        
        $data = explode("\n", trim($value, self::TRIM_CHARACTER_MASKU));
        
        return array_map(function($item) {
            return trim($item, self::TRIM_CHARACTER_MASKU);
        }, $data);
    }    
}
