<?php

namespace App\Controller;

use App\Entity\MiniaturesGroups;
use App\Entity\Qualities;
use App\Entity\Quotes;
use App\Entity\Scales;
use App\Entity\States;
use App\Entity\Users;
use App\Repository\QuotesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

class ApiQuotesController extends AbstractController
{
    /**
     * @Route("/api/getquotes", name="api_quotes_get", methods={"GET"})
     */
    public function getQuotes(QuotesRepository $quotesRepository)
    {
        return $this->json($quotesRepository->findAll(), 200, [], ['groups' => 'quotes:read']);
    }
    /**
     * @Route("/api/getquote/{id}", name="api_quote_get_by_id", methods={"GET"})
     */
    public function getQuoteById(QuotesRepository $quotesRepository, $id)
    {
        return $this->json($quotesRepository->find($id), 200, [], ['groups' => ['quotes:read', 'quotes_by_id:read']]);
    }
    /**
     * @Route("/api/addquote", name="api_quotes_post", methods={"POST"})
     */
    public function addQuote(Request $request, SerializerInterface $serializer){
        $data = json_decode($request->getContent());

        $entityManager = $this->getDoctrine()->getManager();
        try {
            $user = new Users();

            $user->setName($data->user->name);
            $user->setMail($data->user->mail);
            //persist the object so it can be used later
            $entityManager->persist($user);
            
            $quote = new Quotes();
            //retrieve the state object with the state_id in the json file
            $state = $entityManager->getRepository(States::class)->find($data->state_id);
            //complete the "simple" fields with what's on the json
            $quote->setColorScheme($data->colorScheme);
            $quote->setName($data->name);
            $quote->setCreatedAt(new \DateTime());
            //complete the "complex" field with the object found with the id's
            $quote->setState($state);
            $quote->setUser($user);

            $entityManager->persist($quote);
            //put the array in a variable so it can be foreach
            $miniatures_groups = $data->miniaturesGroups;
            
            foreach($miniatures_groups as $group){
                //for every miniature_group in miniatur_groups, create an instance of miniaturesGroups with what you can find in the data, and set the quote with the one that's just been created
                $miniatures_group = new MiniaturesGroups();

                $miniatures_group->setBrand($group->brand);
                $miniatures_group->setComment($group->comment);
                $miniatures_group->setName($group->name);
                $miniatures_group->setQuantity($group->quantity);
                $miniatures_group->setWantBuilt($group->wantBuilt);

                $quality = $entityManager->getRepository(Qualities::class)->find($group->quality_id);
                $scale = $entityManager->getRepository(Scales::class)->find($group->scale_id);

                $miniatures_group->setQuality($quality);
                $miniatures_group->setScale($scale);
                $miniatures_group->setQuote($quote);

                $entityManager->persist($miniatures_group);
            }
            //send the data to the db
            // $entityManager->flush();
            return new Response('ok', 201);

        } catch(NotEncodableValueException $e){
            return $this->json([
                'status'=>400,
                'message'=> $e->getMessage()
            ], 400);
        }
        
        //create a new user and set the name and mail with what's on the json
        
        //on peut personaliser ce qu'on envoie, on pourrait par exemple renvoyer l'objet qu'on vient de créer en json (voir video 33:00)
        //TODO : ajouter des vérifications
        
    }
    
    /**
     * @Route("/api/updatequotestate/{id}", name="updateQuoteState", methods={"PUT"})
     */
    public function updateQuoteState(Request $request, $id){
        $data = json_decode($request->getContent());

        $entityManager = $this->getDoctrine()->getManager();

        $quote = $entityManager->getRepository(Quotes::class)->find($id);

        $user = $quote->getUser();

        $user->setName($data->user->name);
        $user->setMail($data->user->mail);
        //persist the object so it can be used later
        $entityManager->persist($user);

        //retrieve the state object with the state_id in the json file
        $state = $entityManager->getRepository(States::class)->find($data->state_id);
        //complete the "simple" fields with what's on the json
        $quote->setColorScheme($data->colorScheme);
        $quote->setName($data->name);
        $quote->setCreatedAt(new \DateTime());
        //complete the "complex" field with the object found with the id's
        $quote->setState($state);
        $quote->setUser($user);

        $entityManager->persist($quote);
        //put the array in a variable so it can be foreach
        $miniatures_groups = $data->miniaturesGroups;
        
        foreach($miniatures_groups as $group){
            //for every miniature_group in miniatur_groups, create an instance of miniaturesGroups with what you can find in the data, and set the quote with the one that's just been created
            $miniatures_group = new MiniaturesGroups();

            $miniatures_group->setBrand($group->brand);
            $miniatures_group->setComment($group->comment);
            $miniatures_group->setName($group->name);
            $miniatures_group->setQuantity($group->quantity);
            $miniatures_group->setWantBuilt($group->wantBuilt);

            $quality = $entityManager->getRepository(Qualities::class)->find($group->quality_id);
            $scale = $entityManager->getRepository(Scales::class)->find($group->scale_id);

            $miniatures_group->setQuality($quality);
            $miniatures_group->setScale($scale);
            $miniatures_group->setQuote($quote);

            $entityManager->persist($miniatures_group);
        }

        $entityManager->flush();

        return new Response('ok', 201);
    }
    /**
     * @Route("/api/removequote/{id}", name="updateQuoteState", methods={"DELETE"})
     */
    public function removeQuote($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $quote = $entityManager->getRepository(Quotes::class)->find($id); //on récupère la quote pour pouvoir proprement supprimer ses dépendances

        $miniatures_groups = $quote->getMiniaturesGroups();
        
        foreach($miniatures_groups as $group){
            $entityManager->remove($group);
        }

        $entityManager->remove($quote);
        $entityManager->flush();
        return new Response("ok");
    }
}
