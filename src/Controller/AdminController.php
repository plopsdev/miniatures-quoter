<?php

namespace App\Controller;

use App\Entity\Quotes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $quotes = $this->getDoctrine()->getRepository(Quotes::class)->findAll();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'quotes' => $quotes
        ]);
    }
    /**
     * @Route("/admin/{quote_id}", name="admin_details" )
     */
    public function details($quote_id): Response
    {
        $quote = $this->getDoctrine()->getRepository(Quotes::class)->find($quote_id);
        return $this->render('admin/details.html.twig', [
            'quote' => $quote
        ]);
    }
}
