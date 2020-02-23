<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\DataTransformer\StringToArrayTransformer;
use Symfony\Component\Validator\Constraints\NotNull;
use App\Validator\Constraints\ContainsNumberInArray;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

/**
 * Description of SequenceType
 *
 * @author Radosław Skrzypczak <radoslaw.skrzypczak@pearfly.pl>
 */
class SequenceType extends AbstractType
{
    private $transformer;
    
    const MIN_VALUE = 1;
    const MAX_VALUE = 99999;

    public function __construct(StringToArrayTransformer $transformer)
    {
        $this->transformer = $transformer;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('inputData', TextareaType::class, [
            'label'     => 'Dane wejściowe',
            'required'  => true,
            'help' => sprintf('Wprowadź do 10 liczb z przedzialu od %d do %d, każdą w osobnym wierszu.', self::MIN_VALUE, self::MAX_VALUE),            
            'attr'      => [
                'rows'      => 14,
                'cols'      => 20
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Wartość nie powinna być pusta.'
                ]),
                new ContainsNumberInArray([
                    'min' => self::MIN_VALUE,
                    'max' => self::MAX_VALUE
                ])
            ]            
        ]);
        
        $builder->get('inputData')
            ->addModelTransformer($this->transformer);        
        
        $builder->add('btnCalculate', SubmitType::class, [
            'label'=> 'Oblicz'
        ]);
        $builder->add('btnReset', ResetType::class, [
            'label'=> 'Wyczyść dane'
        ]);
    }
}
