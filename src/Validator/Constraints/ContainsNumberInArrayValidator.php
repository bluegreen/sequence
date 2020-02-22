<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

/**
 * Description of ContainsNumberInArrayValidator
 *
 * @author Radosław Skrzypczak <radoslaw.skrzypczak@pearfly.pl>
 */
class ContainsNumberInArrayValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ContainsNumberInArray) {
            throw new UnexpectedTypeException($constraint, ContainsNumberInArray::class);
        }

        if (null === $value || '' === $value) {
            return;
        }
        
        if (!is_array($value)) {
            $this->context->buildViolation('Przekazane dane nie są tablicą!')
                ->addViolation();
        }

        foreach($value as $rowData) {
            if (!is_numeric($rowData)) {
                $this->context->buildViolation($constraint->invalidMessage)
                    ->setParameter('{{ value }}', $this->formatValue($rowData, self::PRETTY_DATE))
                    ->addViolation();

                return;
            }            
        }
        
        //TODO
        //- dodać obsługę zakresow bazując na Range
    }
}