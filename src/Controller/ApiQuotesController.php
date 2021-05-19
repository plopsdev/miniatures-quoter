<?php

namespace App\Controller;

use App\Entity\MiniaturesGroups;
use App\Entity\Qualities;
use App\Entity\Quotes;
use App\Entity\Scales;
use App\Entity\States;
use App\Entity\Users;
use App\Repository\QualitiesRepository;
use App\Repository\QuotesRepository;
use App\Repository\ScalesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

class ApiQuotesController extends AbstractController
{
    
    /**
     * @Route("/api/quotes", name="api_quotes_get", methods={"GET"})
     */
    public function getQuotes(QuotesRepository $quotesRepository)
    {
        return $this->json($quotesRepository->findAll(), 200, [], ['groups' => 'quotes:read']);
    }
    /**
     * @Route("/api/quotes/{id}", name="api_quote_get_by_id", methods={"GET"})
     */
    public function getQuoteById(QuotesRepository $quotesRepository, $id)
    {
        return $this->json($quotesRepository->find($id), 200, [], ['groups' => ['quotes:read', 'quotes_by_id:read']]);
    }
    /**
     * @Route("/api/scales", name="api_quotes_scales", methods={"GET"})
     */
    public function getScales(ScalesRepository $scalesRepository)
    {
        
        return $this->json($scalesRepository->findAll(), 200, [], ['groups' => "scales-qualities:read"]);
    }
    /**
     * @Route("/api/qualities", name="api_quotes_qualities", methods={"GET"})
     */
    public function getQualities(QualitiesRepository $qualitiesRepository)
    {
        return $this->json($qualitiesRepository->findAll(), 200, [], ['groups' => "scales-qualities:read"]);
    }
    /**
     * @Route("/api/quotes", name="api_quotes_post", methods={"POST"})
     */
    public function addQuote(Request $request, SerializerInterface $serializer){
        $data = json_decode($request->getContent()); 

        $entityManager = $this->getDoctrine()->getManager();
        
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
            $entityManager->flush();
            return new JsonResponse(['message' => "ok"], 201);

        
        
        //create a new user and set the name and mail with what's on the json
        
        //on peut personaliser ce qu'on envoie, on pourrait par exemple renvoyer l'objet qu'on vient de créer en json (voir video 33:00)
        //TODO : ajouter des vérifications
        
    }
    
    /**
     * @Route("/api/quotes/{id}", name="updateQuoteState", methods={"OPTIONS", "PUT"})
     */
    public function updateQuoteState(Request $request, $id){
        $data = json_decode($request->getContent());

        $entityManager = $this->getDoctrine()->getManager();

        $quote = $entityManager->getRepository(Quotes::class)->find($id);

        //retrieve the state object with the new_state_id in the json file
        $new_state = $entityManager->getRepository(States::class)->find($data->new_state_id);
 
        //complete the "complex" field with the object found with the id's
        $quote->setState($new_state);

        $entityManager->persist($quote);
        
        $entityManager->flush();

        return new JsonResponse(['message' => "ok"], 201);
    }
    /**
     * @Route("/api/quotes/{id}", name="deleteQuote", methods={"DELETE"})
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
        return new JsonResponse(['message' => "deleted successfuly"], 204);
    }
}
