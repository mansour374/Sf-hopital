<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Services;
use App\Entity\Specialite;
use App\Repository\ServicesRepository;
use App\Repository\SpecialiteRepository;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class MedecinType extends AbstractType
{   
    private $servRepo;
    private $specRepo;



    public function __construct(ServicesRepository $servRepo, SpecialiteRepository $specRepo){
        $this->servRepo = $servRepo;
        $this->specRepo = $specRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          
            ->add('prenom')
            ->add('nom')
            ->add('email', EmailType::class)
            ->add('telephone', NumberType::class)
            ->add('naissance', DateType::class)
            ->add('service', EntityType::class,[
               'class' => Services::class,
               'choice_label' => 'libelle'
           ])
            ->add('specialite', EntityType::class,[
                'class' => Specialite::class,
                'choice_label' => 'libelle',
                'multiple' => true,
                'expanded'=> true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class,
        ]);
    }
}
