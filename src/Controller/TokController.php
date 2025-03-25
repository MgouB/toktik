<?php

namespace App\Controller;

use App\Entity\Tok;
use App\Form\ModifierTokType;
use App\Form\SupprimerTokType;
use App\Form\TokType;
use App\Repository\TokRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TokController extends AbstractController
{
    #[Route('/tok', name: 'app_tok')]
    public function toc(Request $request, EntityManagerInterface $em): Response
    {
        $tok = new Tok();
        $form = $this->createForm(TokType::class, $tok);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $tok->setDateCreation(new \Datetime());
                $tok->setLikes(0);
                $em->persist($tok);
                $em->flush();
                $this->addFlash('notice', 'Message envoyé');
                return $this->redirectToRoute('app_tok');
            }
        }
        return $this->render('base/tok.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/liste-tok', name: 'app_liste_tok')]
    public function listetok(TokRepository $tokRepository,Request $request,EntityManagerInterface $em): Response
    {
        $toks = $tokRepository->findAll();
        $form = $this->createForm(SupprimerTokType::class, null, [
            'toks' => $toks,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $selectedToks = $form->get('toks')->getData();
            foreach ($selectedToks as $tok) {
                $em->remove($tok);
            }
            $em->flush();
            $this->addFlash('notice', 'Tok supprimées avec succès');
            return $this->redirectToRoute('app_liste_tok');
    
        }

        return $this->render('base/liste-tok.html.twig', [
            'toks' => $toks,
            'form' => $form->createView(),

        ]);
    }
    #[Route('/modifier-tok/{id}', name: 'app_modifier_tok')]

    public function modifiertok(Tok $tok): Response
    {
        $form = $this->createForm(ModifierTokType::class, $tok);
        return $this->render('tok/modifier-tok.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/supprimer-tok/{id}', name: 'app_supprimer_tok')]
    public function supprimerTok(Request $request, tok
         $tok, EntityManagerInterface $em): Response {
        if ($tok != null) {
            $em->remove($tok);
            $em->flush();
            $this->addFlash('notice', 'Tok supprimée');
        }
        return $this->redirectToRoute('app_liste_tok');
    }
}
