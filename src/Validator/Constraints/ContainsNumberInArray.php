<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Description of ContainsNumberInArray
 *
 * @author Radosław Skrzypczak <radoslaw.skrzypczak@pearfly.pl>
 */
class ContainsNumberInArray extends Constraint
{
    public $invalidMessage = 'The string "{{ value }}" contains an illegal character: it can only contain letters or numbers.';
}