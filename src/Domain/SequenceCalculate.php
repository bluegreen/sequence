<?php

declare(strict_types=1);

namespace App\Domain;

/**
 * Description of SequenceCalculate
 *
 * @author Radosław Skrzypczak <radoslaw.skrzypczak@pearfly.pl>
 */
final class SequenceCalculate extends Sequence implements Calculate
{
    /**
     * 
     * @param array $sourceData
     * @param int $limit
     * @return array
     */
    public function calculate(array $sourceData, int $limit): void 
    {
        $limitedSourceData = $this->getLimitSounceData($sourceData, $limit);
        
        foreach($limitedSourceData as $value) {
            $value = (int)$value;
            $this->setSequenceKey($value);
            $this-> init();
            $this->calculateValuesInSequece($value);
        }
        
        foreach($limitedSourceData as $value) {
            $value = (int)$value;
            $this->setSequenceKey($value);
            $this-> init();
            $this->calculateMissingValuesInSequece();
        }        
    }
    
    /**
     * 
     * @return array
     */
    public function getResult(): array 
    {
        return $this->allValuesOfSequence;
    }
    
    /**
     * 
     * @param array $data
     * @return array
     */
    public function getMaxValueOfAllSequence(): array 
    {
        foreach($this->allValuesOfSequence as $key => $value) {
            $this->maxValuesOfAllSequence[$key] = max($value);
        }
        
        return $this->maxValuesOfAllSequence;
    }
    
    /**
     * 
     * @return void
     */
    private function init(): void
    {
        $this->allValuesOfSequence[$this->sequenceKey][0] = 0;
        $this->allValuesOfSequence[$this->sequenceKey][1] = 1;                
    }
    
    /**
     * 
     * @return void
     */
    private function calculateMissingValuesInSequece(): void
    {
        while(sizeof($this->itemsOfSequence[$this->sequenceKey]) > 0 ) { 
            foreach($this->itemsOfSequence[$this->sequenceKey] as $n) {
                if(!isset($this->allValuesOfSequence[$this->sequenceKey][$n])) {
                    $this->calculateValuesInSequece($n);
                } else {
                    unset($this->itemsOfSequence[$this->sequenceKey][$n]);
                }
            }
        }
    }
    
    /**
     * 
     * @param type $n
     * @return void
     */
    private function calculateValuesInSequece($n): void
    {   
        $this->itemsOfSequence[$this->sequenceKey][$n] = $n;
        
        if($n % 2 === 0) {
            if(!isset($this->allValuesOfSequence[$this->sequenceKey][$n])) {
                if(!isset($this->allValuesOfSequence[$this->sequenceKey][$n/2])) {
                    $this->calculateValuesInSequece($n/2);
                } else {
                    $this->allValuesOfSequence[$this->sequenceKey][$n] = $this->allValuesOfSequence[$this->sequenceKey][$n/2];                
                }
            }
        } else {            
            if(!isset($this->allValuesOfSequence[$this->sequenceKey][($n-1)/2]) || !isset($this->allValuesOfSequence[$this->sequenceKey][(($n-1)/2)+1])) {
                $i = [($n-1)/2, (($n-1)/2)+1];
                foreach($i as $v) {
                    if(!isset($this->allValuesOfSequence[$this->sequenceKey][$v])) {
                        $this->calculateValuesInSequece($v);
                    }
                }
            } else {
                $this->allValuesOfSequence[$this->sequenceKey][$n] = $this->allValuesOfSequence[$this->sequenceKey][($n-1)/2] + $this->allValuesOfSequence[$this->sequenceKey][(($n-1)/2)+1];                
            }            
        }
    }
}