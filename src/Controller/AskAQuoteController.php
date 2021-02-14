<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AskAQuoteController extends AbstractController
{
    /**
     * @Route("/ask-a-quote", name="ask_a_quote")
     */
    public function index(): Response
    {
        return $this->render('ask_a_quote/index.html.twig', [
            'controller_name' => 'AskAQuoteController',
        ]);
    }
}
