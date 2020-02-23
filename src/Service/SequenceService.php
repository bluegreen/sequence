<?php

declare(strict_types=1);

namespace App\Service;

use App\Domain\Calculate;

/**
 * Description of SequenceService
 *
 * @author Radosław Skrzypczak <radoslaw.skrzypczak@pearfly.pl>
 */
final class SequenceService 
{
    private $sequenceCalculate;
        
    public function __construct(Calculate $sequenceCalculate) 
    {
        $this->sequenceCalculate = $sequenceCalculate;
    }
    
    /**
     * 
     * @param array $sourceData
     * @param int $limit
     * @return array
     */
    public function calculateSequence(array $sourceData, int $limit): array
    {
        $this->sequenceCalculate->calculate($sourceData, $limit);
        
        return $this->sequenceCalculate->getMaxValueOfAllSequence();
    }    
}
