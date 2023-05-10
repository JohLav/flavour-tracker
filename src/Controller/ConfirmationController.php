<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfirmationController extends AbstractController
{
    #[Route('/reservation/confirmation', name: 'app_confirmation')]
    public function show(): Response
    {
        return $this->render('confirmation/show.html.twig', [
            'controller_name' => 'ConfirmationController',
        ]);
    }
}
