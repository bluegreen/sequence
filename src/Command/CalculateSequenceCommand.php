<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Question\Question;
use App\Form\SequenceType;
use App\Service\SequenceService;
use Symfony\Component\Console\Helper\Table;

/**
 * Description of CalculateSequenceCommand
 *
 * @author Radosław Skrzypczak <radoslaw.skrzypczak@pearfly.pl>
 */
class CalculateSequenceCommand extends Command
{
    use LockableTrait;
    
    protected static $defaultName = 'app:calculate-sequence';
    private $sequenceService;

    const TRIM_CHARACTER_MASKU = " \t\n\r\0\x0B";
    
    public function __construct(SequenceService $sequenceService)
    {
        $this->sequenceService = $sequenceService;

        parent::__construct();
    }    

    protected function configure()
    {
        $this->setDescription('Calculation of the maximum value in a sequence.');        
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');

            return 0;
        }
        
        $io = new SymfonyStyle($input, $output);
        $io->title('Aplikacja Sequence służy do znajdywania maksymalnej wartości w ciągu na podstawie podenego n');        
        
        $helper = $this->getHelper('question'); 

        $question = new Question(sprintf('Wprowadź do 10 liczb z przedzialu od %d do %d, każdą oddziel przecinkiem: ', 
            SequenceType::MIN_VALUE, SequenceType::MAX_VALUE));

        $this->dataValidation($question);
        
        $answer = $helper->ask($input, $output, $question);        

        $sequenceResult = $this->sequenceService->calculateSequence($answer, (int)getenv('SEQUENCE_VALUE_LIMIT'));
        
        $data = [];
        
        foreach($sequenceResult as $key => $value) {
            $data[] = [$key, $value];
        }
        
        $io->newLine();
        
        $table = new Table($output);
        $table
            ->setHeaders(['Dane wejściowe', 'Dane wyjściowe'])
            ->setRows($data);
        
        $table->render();

        $this->release();
        return 0;
    }

    private function dataValidation($question)
    {
        $question->setValidator(function ($answer) {
            $data = explode(",", trim($answer, self::TRIM_CHARACTER_MASKU));
            
            $trimedData =  array_map(function($item) {
                return trim($item, self::TRIM_CHARACTER_MASKU);
            }, $data);
            
            foreach($trimedData as $value) {
                if (!is_numeric($value)) {
                    throw new \RuntimeException(
                        sprintf('Wartość "%s" powinna być liczbą.', $value)
                    );
                }
                
                if ($value < SequenceType::MIN_VALUE || $value > SequenceType::MAX_VALUE) {
                    throw new \RuntimeException(
                        sprintf('Wprowadzona wartość powinna mieścić się w przedziale od %d do %d.', 
                        SequenceType::MIN_VALUE, SequenceType::MAX_VALUE)
                    );                    
                }                            
            }

            return $data;
        });        
    }
}
