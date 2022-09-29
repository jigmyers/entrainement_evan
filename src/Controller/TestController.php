<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/', name: 'app_test')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $roleRepo = $doctrine->getRepository(Role::class)->findAll();




        if(isset($_POST['nom'])){
            $roleRepo2 = $doctrine->getRepository(Role::class);
            $entityManager = $doctrine->getManager();

            $nom = htmlspecialchars($_POST['nom']);
            $prenom = htmlspecialchars($_POST['prenom']);
            $role = htmlspecialchars($_POST['role']);

            $user = new User();
            $user->setNom($nom)
                 ->setPrenom($prenom)
                 ->setIdRole($roleRepo2->findOneBy(['id' => $role]));


            $entityManager->persist($user);
            $entityManager->flush();

            $message = 'Votre compte à été crée';


        } else {
            $message = '';
        }


        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'message' => $message,
            'roleRepo' => $roleRepo
        ]);
    }
}
