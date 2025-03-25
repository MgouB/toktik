<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\TokType;

final class BaseController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('base/index.html.twig', [

        ]);
    }
    #[Route('/tok', name: 'app_tok')]
    public function tok(): Response
    {
        $form = $this->createForm(TokType::class);
        return $this->render('base/tok.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
