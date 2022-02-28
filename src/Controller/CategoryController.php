<?php

namespace App\Controller;

use App\Form\CategoryFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController{
    
    #[Route('/addCategory' , name:"addCategory")]
    #[IsGranted('ROLE_ADMIN')]
    public function newCategory(Request $request, EntityManagerInterface $em){
        $form=$this->createForm(CategoryFormType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $category = $form->getData();
            $em->persist($category);
            $em->flush();
        }
        return $this->renderForm('/app/categories/createcategory.html.twig', ["categoryForm"=>$form]);
    }
}