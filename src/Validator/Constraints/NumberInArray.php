<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Description of NumberInArray
 *
 * @author Radosław Skrzypczak <radoslaw.skrzypczak@pearfly.pl>
 */
class NumberInArray extends Constraint
{
    public $notInRangeMessage = 'Wprowadzona wartość powinna mieścić się w przedziale od {{ min }} do {{ max }}.';
    public $invalidMessage = 'Wartość "{{ value }}" powinna być liczbą.';
    public $nullOrBlankMessage = 'Wartość "{{ value }}" nie powinna być pusta.';
    public $min;
    public $max;    
}