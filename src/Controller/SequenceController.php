<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SequenceType;

/**
 * Description of SequenceController
 *
 * @author Radosław Skrzypczak <radoslaw.skrzypczak@pearfly.pl>
 */
class SequenceController extends AbstractController
{
    public function start(Request $request): Response
    {
        $form = $this->createForm(SequenceType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                return $this->render('sequence/result.html.twig',[
                    'sequence' => $form->getData(),
                ]);                
            } catch (\Exception $e) {
                $this->addFlash(
                    'warning',
                    $e->getMessage()
                );
            }            
        }
        
        return $this->render('sequence/start.html.twig', [
            'form' => $form->createView(),
        ]);        
    }
}
