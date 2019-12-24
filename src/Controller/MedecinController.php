<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Form\MedecinType;
use App\utils\MatriculeGenerator;
use App\Repository\MedecinRepository;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MedecinController extends AbstractController
{
    /**
     * @Route("/medecin", name="medecin")
     */
    public function index()
    {
        return $this->render('medecin/index.html.twig', [
            'controller_name' => 'MedecinController',
        ]);
    }

     /**
     * @Route("/medecin/liste", name="medecin_liste")
     */
    public function viewmed(MedecinRepository $repo)
    {
        $medecins = $repo->findAll();
        return $this->render('medecin/liste.html.twig', [
            'medecins' => $medecins
        ]);
    }
    

    /**
     * @Route("/medecin/new", name="medecin_new")
     * @Route("/medecin/{id}/edit", name="medecin_edit")
     */
    public function form(Medecin $medecin = null, Request $request, MedecinRepository $medecinRepo, MatriculeGenerator $mat_generator )
    {
       if(!$medecin){
        $medecin = new Medecin();
       }
        

        $form = $this->createform(MedecinType::class, $medecin);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();

            if(!$medecin->getId()){
            $matricule = $mat_generator->generate($medecin);
            $medecin->setMatricule($matricule);
            }

            $em->persist($medecin);
            $em->flush();
            return $this->redirectToRoute('medecin_new');

        }
           
        return $this->render('medecin/new.html.twig', [
            'form' => $form->createView(),
            'editMode' => $medecin->getId() !==null
            
        ]);
    }
    
}

