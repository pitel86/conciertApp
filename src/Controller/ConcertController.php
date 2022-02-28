<?php

namespace App\Controller;

use App\Form\ConcertFormType;
use App\Form\FilterCategoryConcertFormType;
use App\Entity\Concert;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConcertController extends AbstractController{
    
    #[Route('/addConcert' , name:"addConcert")]
    #[IsGranted('ROLE_ADMIN')]
    public function newConcert(Request $request, EntityManagerInterface $em){
        $form=$this->createForm(ConcertFormType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $concert = $form->getData();
            $em->persist($concert);
            $em->flush();
            return $this->redirectToRoute('listConcert');
        }
        return $this->renderForm('/app/concerts/createconcert.html.twig', ["concertForm"=>$form]);
    }
    
    #[Route('/editConcert/{id}' , name:"editConcert")]
    #[IsGranted('ROLE_ADMIN')]
    public function editConcert($id, Request $request, EntityManagerInterface $em){
        $repository = $em->getRepository(Concert::class);
        $concert=$repository->find($id);
        $form=$this->createForm(ConcertFormType::class, $concert);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $concert = $form->getData();
            $em->flush();
            return $this->redirectToRoute('listConcert');
        }
        return $this->renderForm('/app/concerts/createconcert.html.twig', ["concertForm"=>$form]);
    }

    #[Route('/concert/{id}', name:"showConcert")]
    public function showConcert($id, EntityManagerInterface $em){
        $repository = $em->getRepository(Concert::class);
        $concert=$repository->find($id);
        return $this->render('/app/concerts/showConcert.html.twig', ["concert"=>$concert]);
    }


    /*#[Route('/concerts' , name:"listConcert")]
    public function listConcert(EntityManagerInterface $em){
        $repository = $em->getRepository(Concert::class);
        $concerts=$repository->findAll();
        return $this->render('/app/concerts/listConcerts.html.twig', ["concerts"=>$concerts]);
    }*/



    #[Route('/concerts' , name:"listConcert")]
    public function listConcert(Request $request, EntityManagerInterface $em){
        $form=$this->createForm(FilterCategoryConcertFormType::class);
        $form->handleRequest($request);
        $repository = $em->getRepository(Concert::class);
        $concerts=$repository->findAll();
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $category = $form->getData();
            $categories = $category->getCategories();
            $concerts = $repository->findByCategory($categories[0]);
        }
        return $this->renderForm('/app/concerts/listConcerts.html.twig', ["concerts"=>$concerts,"concertFilter"=>$form]);
    }

    #[Route('/myConcerts' , name:"myConcerts")]
    #[IsGranted('ROLE_USER')]
    public function listUserFestival(EntityManagerInterface $em){
        $user = $this->getUser();
        $concerts = $user->getConcerts();   
        return $this->render('/app/concerts/myConcerts.html.twig', ["concerts"=>$concerts]);
    }

    #[Route('/addToMyConcerts/{id}', name:"addToMyConcerts")]
    #[IsGranted('ROLE_USER')]
    public function addToMyConcerts($id, EntityManagerInterface $em){
        $user = $this->getUser();
        $repository = $em->getRepository(Concert::class);
        $concert=$repository->find($id);
        $user->addConcert($concert);
        $em->flush();        
        return $this->redirectToRoute('myConcerts');
    }
}