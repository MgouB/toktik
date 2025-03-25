<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TokController extends AbstractController
{
    #[Route('/tok', name: 'app_tok')]
    public function index(): Response
    {
        return $this->render('tok/index.html.twig', [
            'controller_name' => 'TokController',
        ]);
    }
}
