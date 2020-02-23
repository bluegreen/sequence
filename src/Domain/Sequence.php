<?php

declare(strict_types=1);

namespace App\Domain;

/**
 * Description of Sequence
 *
 * @author Radosław Skrzypczak <radoslaw.skrzypczak@pearfly.pl>
 */
abstract class Sequence 
{
    protected $itemsOfSequence = [];
    protected $allValuesOfSequence = [];
    protected $maxValuesOfAllSequence = [];
    protected $sequenceKey;
    
    /**
     * 
     * @param array $data
     * @param int $limit
     * @return array
     */
    protected function getLimitSounceData(array $data, int $limit): array
    {
        return array_slice($data, 0, $limit);
    }
    
    /**
     * 
     * @param int $sequenceKey
     * @return void
     */
    protected function setSequenceKey(int $sequenceKey): void
    {
        $this->sequenceKey = $sequenceKey;
    }
    
}
