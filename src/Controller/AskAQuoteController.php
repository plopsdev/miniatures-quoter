<?php

namespace App\Controller;

use App\Entity\MiniaturesGroups;
use App\Entity\Quotes;
use App\Entity\Users;
use App\Entity\States;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\Type\QuoteType;
use App\Form\Type\UserType;
use App\Form\Type\MiniaturesGroupType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class AskAQuoteController extends AbstractController
{
    
    /**
     * @Route("/ask-a-quote/user-form", name="ask_a_quote_user_form")
     */
    public function newUser(Request $request): Response
    {
        $user = new Users();
        $user_form = $this->createForm(UserType::class, $user);
        $user_form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();

        if($user_form->isSubmitted() && $user_form->isValid()) {

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('ask_a_quote_quote_form', ['user_id' => $user->getId()]); // ce qui est passé dans l'url
        }

        return $this->render('ask_a_quote/user_form.html.twig', [
            'userForm' => $user_form->createView()
        ]);
    }
    
    /**
     * @Route("/ask-a-quote/quote-form/{user_id}", name="ask_a_quote_quote_form")
     */
    public function newQuote(Request $request, $user_id): Response
    {   
        $quote = new Quotes();
        
        $quote_form = $this->createForm(QuoteType::class, $quote);
        
        $quote_form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(Users::class)->find($user_id); //récupère l'user grâce à l'ID passée par l'action précédente (plus haute)
        $waiting_state = $entityManager->getRepository(States::class)->find(1);

        if($quote_form->isSubmitted() && $quote_form->isValid()) {
            $quote->setCreatedAt(new \DateTime());
            $quote->setState($waiting_state);
            $quote->setUser($user);
            $entityManager->persist($quote); // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->flush();

            return $this->redirectToRoute('ask_a_quote_miniatures_group_form', ['quote_id' => $quote->getId()]);
        }

        // $form = $this->createForm(TaskType::class, $quote);

        return $this->render('ask_a_quote/quote_form.html.twig', [
            'quoteForm' => $quote_form->createView()
        ]);
    }
    /**
     * @Route("/ask-a-quote/miniatures-group-form/{quote_id}", name="ask_a_quote_miniatures_group_form")
     */
    public function newMiniaturesGroups(Request $request, $quote_id): Response 
    {
        $miniatures_group = new MiniaturesGroups();
        $miniatures_group_form = $this->createForm(MiniaturesGroupType::class, $miniatures_group);

        $miniatures_group_form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        $quote = $entityManager->getRepository(Quotes::class)->find($quote_id);
        if($miniatures_group_form->isSubmitted() && $miniatures_group_form->isValid()){
            $miniatures_group->setQuote($quote);
            $entityManager->persist($miniatures_group);
            $entityManager->flush();

            return $this->redirectToRoute('ask_a_quote_confirmation');
        }
        
        return $this->render('ask_a_quote/miniatures_group_form.html.twig', [
            'miniaturesGroupForm' => $miniatures_group_form->createView()
        ]);
    }
    /**
     * @Route("/ask-a-quote/confirmation", name="ask_a_quote_confirmation")
     */
    public function quoteConfirmation(): Response
    {
        return $this->render('ask_a_quote/confirmation.html.twig');
    }

    
    
}
