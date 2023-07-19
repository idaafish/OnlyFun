<?php

namespace App\Controller;

use App\Entity\Video;
use App\Entity\User;
use App\Entity\VideoCategoria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{

    
    private $em;
    public $oKKo = "Todo Correcto";
    //Constructor
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/user', name: 'user')]
    public function index(): Response
    {
        // creamos obj User
        $user = new User();
        $user->setNombre("");
        $user->setFecha(new \DateTime());
        $user->setUsuario((""));
        $user->setPassword((""));



        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
            'mensage' => $this->oKKo
        ]);
    }

    #[Route('/crearUser', name: 'crearUser')]
    public function new(): Response
    {
        // creamos obj User
        $user = new User();

        //rellenamos valores
        $variableRandom =rand(1,5000000);
        $user->setNombre("Nombre".$variableRandom);
        $user->setFecha(new \DateTime());
        $user->setUsuario("User".$variableRandom);
        $user->setPassword("pass".$variableRandom);

        //persistimos
        $this->em->persist($user);


        // ejecutamos la query, por ejemplo, el insertar. 
        $this->em->flush();

       
        return $this->render('user/index.html.twig', [
            'controller_name' => "Guarda la User  ".$user->getNombre(),
            'user' => $user,
            'mensage' => $this->oKKo
       ]);
    }
}
