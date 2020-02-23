<?php

declare(strict_types=1);

namespace App\Domain;

/**
 * Description of Calculate
 *
 * @author Radosław Skrzypczak <radoslaw.skrzypczak@pearfly.pl>
 */
interface Calculate 
{
    public function calculate(array $sourceData, int $limit): void;
    public function getResult(): array;
    public function getMaxValueOfAllSequence(): array;
}
