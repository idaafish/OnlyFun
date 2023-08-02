<?php

namespace App\Controller;

use App\Entity\Video;
use App\Entity\Categoria;
use App\Entity\VideoCategoria;
use App\DTO\VideoViewModel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VideoController extends AbstractController
{

    private $em;
    public $oKKo = "Todo Correcto";
    //Constructor
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    #[Route('/video', name: 'video')]
    public function index(): Response
    {
        $videoVista = new VideoViewModel(0,"","","","","");

        return $this->render('video/index.html.twig', [
            'controller_name' => 'VideoController',
            'video' => $videoVista,
            'mensage' => $this->oKKo
        ]);
    }

     // Crea Video
     #[Route('/crearVideo', name: 'crearVideo')]
     public function new(): Response
     {
         // creamos obj Video
         $video = new Video();
 
         //rellenamos valores
         $variableRandom =rand(1,5000000);
         $video->setNombre(" el nombre es ".$variableRandom);
         $video->setDescripcion(" BLA BLA BLA ".$variableRandom." BLA BLA BLA");
         $video->setUrl("URL@".$variableRandom.".com");
         
        //persistimos
        $this->em->persist($video);

        // ejecutamos la query, por ejemplo, el insertar. 
        $this->em->flush();

        
        for ($i = 0; $i < rand(1,10); $i++) { 
            // inicializamos el video categoria y categoria
            $videoCategoria = new VideoCategoria();
            $categoria = new Categoria();
            
            //recuperamos la categoria a partir de un ID
            $categoria = $this->em->getRepository(Categoria::class)->find($i+1);
            $videoCategoria->setCategoria($categoria);

            // seteamos el video en categoria Video
            $videoCategoria->setVideo($video);

            //persistimos
            $this->em->persist($videoCategoria);

            // ejecutamos la query, por ejemplo, el insertar. 
            $this->em->flush();
        }   
        
        $videoVista = new VideoViewModel(
            $video->getId(),
            $video->getNombre(),
            $video->getUrl(),
            $video->getDescripcion(),
            "categoria 1, categoria 2",
            "usuario 1"
        );

        return $this->render('video/index.html.twig', [
            'controller_name' => "la video es ".$video->getNombre(),
            'video' => $videoVista,
            'mensage' => $this->oKKo
        ]);
     }

     #[Route('/mostrarVideo/{request,id}', name: 'mostrarVideo')]
     public function show(Request $request): Response
     {
         $idRequest=$request->request->get('id');
         // creamos obj Video
         $video = new Video();
 
         //recuperamos el video
         $video = $this->em->getRepository(Video::class)->find($idRequest);
 
         // validamos que citas venga relleno
         if (!$video) {
             throw $this->createNotFoundException('No se encontró el usuario con el ID: '.$idRequest);
         } 
 
        
         return $this->render('video/index.html.twig', [
             'controller_name' => "Guarda el Video  ".$video->getNombre(),
             'video' => $video,
             'mensage' => $this->oKKo
        ]);
     }
 
     #[Route('/cambiarVideo/{request,id}', name: 'cambiarVideo')]
     public function update(Request $request): Response
     {
         $idRequest=$request->request->get('id');
         // creamos obj Video
         $video = new Video();
 
         //recuperamos el video
         $video = $this->em->getRepository(Video::class)->find($idRequest);
 
         // validamos que citas venga relleno
         if (!$video) {
             throw $this->createNotFoundException('No se encontró el video con el ID: '.$idRequest);
         } else {
 
             //modificamos
             $video->setNombre("Nombre MODIFICADO");
 
             //persistimos
             $this->em->persist($video);
     
               // ejecutamos la query, por ejemplo, el insertar. 
             $this->em->flush();
         }
        
         return $this->render('video/index.html.twig', [
             'controller_name' => "Guarda el Video  ".$video->getNombre(),
             'video' => $video,
             'mensage' => $this->oKKo
        ]);
     }
 
     #[Route('/borrarVideo/{request,id}', name: 'borrarVideo')]
     public function delete(Request $request): Response
     {
         $idRequest=$request->request->get('id');
         // creamos obj Video
         $video = new Video();
 
         //recuperamos el video
         $video = $this->em->getRepository(Video::class)->find($idRequest);
 
         //eliminamos la cita seleccionada
         $this->em->remove($video);
         $this->em->flush();
 
         // validamos que citas venga relleno
         if (!$video) {
             throw $this->createNotFoundException('No se encontró el video con el ID: '.$idRequest);
         } 
 
        
         return $this->render('video/index.html.twig', [
             'controller_name' => "Guarda el Video  ".$video->getNombre(),
             'video' => $video,
             'mensage' => $this->oKKo
        ]);
     }
}
