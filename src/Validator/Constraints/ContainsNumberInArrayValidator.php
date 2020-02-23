<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

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

        $min = $constraint->min;
        $max = $constraint->max;
        
        $hasLowerLimit = null !== $min;
        $hasUpperLimit = null !== $max;
        
        foreach($value as $rowValue) {
            if (null === $rowValue || '' === $rowValue) {
                $this->context->buildViolation($constraint->nullOrBlankMessage)
                    ->setParameter('{{ value }}', $rowValue)
                    ->addViolation();

                return;                
            }
            
            if (!is_numeric($rowValue)) {
                $this->context->buildViolation($constraint->invalidMessage)
                    ->setParameter('{{ value }}', $rowValue)
                    ->addViolation();

                return;
            }
            
            if ($hasLowerLimit && $hasUpperLimit && ($rowValue < $min || $rowValue > $max)) {
                $violationBuilder = $this->context->buildViolation($constraint->notInRangeMessage)
                    ->setParameter('{{ min }}', $min)
                    ->setParameter('{{ max }}', $max);

                $violationBuilder->addViolation();

                return;
            }            
        }
        
    }
}