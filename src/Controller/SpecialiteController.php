<?php

namespace App\Controller;

use App\Entity\Specialite;
use App\Form\SpecialiteType;
use App\Repository\SpecialiteRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SpecialiteController extends AbstractController
{
    /**
     * @Route("/specialite", name="specialite")
     */
    public function index()
    {
        return $this->render('specialite/index.html.twig', [
            'controller_name' => 'SpecialiteController',
        ]);
    }

    /**
     * @Route("/specialite/new", name="specialite_new")
     */
    public function create( Request $request, SpecialiteRepository $specialiteRepo,ObjectManager $manager){

        $specialite = new Specialite();

        $form = $this->createForm(SpecialiteType::class, $specialite);

        $form->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid()){
            
            $manager->persist($specialite);
            $manager->flush();

            return $this->redirectToRoute('specialite_new');
        }

        return $this->render('specialite/new.html.twig' , [
            'formSpecialite' => $form->createView(),
        ]);
    }
}
