<?php

namespace App\Controller;

use App\Form\ConcertFormType;
use App\Entity\Concert;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConcertController extends AbstractController{
    
    #[Route('/addConcert' , name:"addConcert")]
    public function newConcert(Request $request, EntityManagerInterface $em){
        $form=$this->createForm(ConcertFormType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $concert = $form->getData();
            $em->persist($concert);
            $em->flush();
        }
        return $this->renderForm('/app/concerts/createconcert.html.twig', ["concertForm"=>$form]);
    }

    #[Route('/concert/{id}', name:"showConcert")]
    public function showConcert($id, EntityManagerInterface $em){
        $repository = $em->getRepository(Concert::class);
        $concert=$repository->find($id);
        return $this->render('/app/concerts/showConcert.html.twig', ["concert"=>$concert]);
    }


    #[Route('/concerts' , name:"listConcert")]
    public function listConcert(EntityManagerInterface $em){
        $repository = $em->getRepository(Concert::class);
        $concerts=$repository->findAll();
        return $this->render('/app/concerts/listConcerts.html.twig', ["concerts"=>$concerts]);
    }

    #[Route('/myConcerts' , name:"myConcerts")]
    public function listUserFestival(EntityManagerInterface $em){
        $user = $this->getUser();
        $concerts = $user->getConcerts();   
        return $this->render('/app/concerts/listConcerts.html.twig', ["concerts"=>$concerts]);
    }

    #[Route('/addToMyConcerts/{id}', name:"addToMyConcerts")]
    public function addToMyConcerts($id, EntityManagerInterface $em){
        $user = $this->getUser();
        $repository = $em->getRepository(Concert::class);
        $concert=$repository->find($id);
        $user->addConcert($concert);
        $em->flush();
        return new Response('');
    }
}