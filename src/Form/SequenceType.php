<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\DataTransformer\StringToArrayTransformer;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Collection;
use App\Validator\Constraints\ContainsNumberInArray;

/**
 * Description of SequenceType
 *
 * @author Radosław Skrzypczak <radoslaw.skrzypczak@pearfly.pl>
 */
class SequenceType extends AbstractType
{
    private $transformer;
    
    public function __construct(StringToArrayTransformer $transformer)
    {
        $this->transformer = $transformer;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('inputData', TextareaType::class, [
            'label'     => 'Dane wejściowe',
            'required'  => true,
            'help' => 'Wprowadź do 10 liczb z przedzialu od 1 do 99 999, każdą w osobnym wierszu.',            
            'attr'      => [
                'rows'      => 14,
                'cols'      => 20
            ],
            'constraints' => [
                new NotNull(),
                new ContainsNumberInArray()
//                new Collection([
//                    new Assert\Optional([
//                        new Assert\Type('array'),
//                        new Assert\Count(['min' => 1]),
//                        new Range([
//                            'min' => 1,
//                            'max' => 99999,
//                            'minMessage' => 'You must be at least {{ limit }}cm tall to enter',
//                            'maxMessage' => 'You cannot be taller than {{ limit }}cm to enter',                    
//                        ])
//                    ]),                    
//                ])
                
            ]            
        ]);
        
        $builder->get('inputData')
            ->addModelTransformer($this->transformer);        
        
        $builder->add('save', SubmitType::class, [
            'label'=> 'Oblicz'
        ]);
    }
}
