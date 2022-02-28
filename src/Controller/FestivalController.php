<?php

namespace App\Controller;

use App\Form\FestivalFormType;
use App\Entity\Festival;
use App\Form\FilterCategoryFestivalFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FestivalController extends AbstractController{
    
    #[Route('/addFest' , name:"addFest")]
    #[IsGranted('ROLE_ADMIN')]
    public function newFestival(Request $request, EntityManagerInterface $em){
        $form=$this->createForm(FestivalFormType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $festival = $form->getData();
            $em->persist($festival);
            $em->flush();
            return $this->redirectToRoute('listFestival');
        }
        return $this->renderForm('/app/festivals/createfestival.html.twig', ["festivalForm"=>$form]);
    }

        
    #[Route('/editFestival/{id}' , name:"editFestival")]
    #[IsGranted('ROLE_ADMIN')]
    public function editFestival($id, Request $request, EntityManagerInterface $em){
        $repository = $em->getRepository(Festival::class);
        $festival=$repository->find($id);
        $form=$this->createForm(FestivalFormType::class, $festival);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $festival = $form->getData();
            $em->persist($festival);
            $em->flush();
            return $this->redirectToRoute('listFestival');
        }
        return $this->renderForm('/app/festivals/createfestival.html.twig', ["festivalForm"=>$form]);
    }


    #[Route('/festival/{id}', name:"showFestival")]
    public function showFestival($id, EntityManagerInterface $em){
        $repository = $em->getRepository(Festival::class);
        $festival=$repository->find($id);
        return $this->render('/app/festivals/showFestival.html.twig', ["festival"=>$festival]);
    }

    #[Route('/festivals' , name:"listFestival")]
    public function listConcert(Request $request, EntityManagerInterface $em){
        $form=$this->createForm(FilterCategoryFestivalFormType::class);
        $form->handleRequest($request);
        $repository = $em->getRepository(Festival::class);
        $festivals=$repository->findAll();
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $category = $form->getData();
            $categories = $category->getCategories();
            $festivals = $repository->findByCategory($categories[0]);
        }
        return $this->renderForm('/app/festivals/listFestivals.html.twig', ["festivals"=>$festivals,"festivalFilter"=>$form]);
    }


    /*#[Route('/festivals' , name:"listFestival")]
    public function listFestival(EntityManagerInterface $em){
        $repository = $em->getRepository(Festival::class);
        $festivals=$repository->findAll();
        return $this->render('/app/festivals/listFestivals.html.twig', ["festivals"=>$festivals]);
    }*/

    #[Route('/myFestivals' , name:"myFestivals")]
    #[IsGranted('ROLE_USER')]
    public function listUserFestival(EntityManagerInterface $em){
        $user = $this->getUser();
        $festivals = $user->getFestivals();   
        return $this->render('/app/festivals/myFestivals.html.twig', ["festivals"=>$festivals]);
    }


    #[Route('/addToMyFests/{id}', name:"addToMyFests")]
    #[IsGranted('ROLE_USER')]
    public function addToMyFests($id, EntityManagerInterface $em){
        $user = $this->getUser();
        $repository = $em->getRepository(Festival::class);
        $festival=$repository->find($id);
        $user->addFestival($festival);
        $em->flush();
        return $this->redirectToRoute('myFestivals');
    }
}