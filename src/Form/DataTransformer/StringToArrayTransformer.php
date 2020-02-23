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
        
        $characterMask = " \t\n\r\0\x0B";
        
        $data = explode("\n", trim($value, $characterMask));
        
        return array_map(function($item) use ($characterMask) {
            return trim($item, $characterMask);
        }, $data);
    }    
}
