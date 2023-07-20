<?php

namespace App\Controller;

use App\Entity\Video;
use App\Entity\User;
use App\Entity\VideoCategoria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route('/mostrarUser/{request,id}', name: 'mostrarUser')]
    public function show(Request $request): Response
    {
        $idRequest=$request->request->get('id');
        // creamos obj User
        $user = new User();

        //recuperamos el user
        $user = $this->em->getRepository(User::class)->find($idRequest);

        // validamos que citas venga relleno
        if (!$user) {
            throw $this->createNotFoundException('No se encontró el usuario con el ID: '.$idRequest);
        } 

       
        return $this->render('user/index.html.twig', [
            'controller_name' => "Guarda el User  ".$user->getNombre(),
            'user' => $user,
            'mensage' => $this->oKKo
       ]);
    }

    #[Route('/cambiarUser/{request,id}', name: 'cambiarUser')]
    public function update(Request $request): Response
    {
        $idRequest=$request->request->get('id');
        // creamos obj User
        $user = new User();

        //recuperamos el user
        $user = $this->em->getRepository(User::class)->find($idRequest);

        // validamos que citas venga relleno
        if (!$user) {
            throw $this->createNotFoundException('No se encontró el user con el ID: '.$idRequest);
        } else {

            //modificamos
            $user->setNombre("Nombre MODIFICADO");

            //persistimos
            $this->em->persist($user);
    
              // ejecutamos la query, por ejemplo, el insertar. 
            $this->em->flush();
        }
       
        return $this->render('user/index.html.twig', [
            'controller_name' => "Guarda el User  ".$user->getNombre(),
            'user' => $user,
            'mensage' => $this->oKKo
       ]);
    }

    #[Route('/borrarUser/{request,id}', name: 'borrarUser')]
    public function delete(Request $request): Response
    {
        $idRequest=$request->request->get('id');
        // creamos obj User
        $user = new User();

        //recuperamos el user
        $user = $this->em->getRepository(User::class)->find($idRequest);

        //eliminamos la cita seleccionada
        $this->em->remove($user);
        $this->em->flush();

        // validamos que citas venga relleno
        if (!$user) {
            throw $this->createNotFoundException('No se encontró el usuario con el ID: '.$idRequest);
        } 

       
        return $this->render('user/index.html.twig', [
            'controller_name' => "Guarda el User  ".$user->getNombre(),
            'user' => $user,
            'mensage' => $this->oKKo
       ]);
    }
}
