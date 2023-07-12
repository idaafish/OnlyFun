<?php

namespace App\Controller;

use App\Entity\Video;
use App\Entity\Categoria;
use App\Entity\VideoCategoria;
use Doctrine\ORM\EntityManagerInterface;
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
        $video = new Video();
 
        //rellenamos valores
        $video->setNombre("");
        $video->setDescripcion("");
        $video->setUrl("");

        return $this->render('video/index.html.twig', [
            'controller_name' => 'VideoController',
            'video' => $video,
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

        /*for ($i = 0; $i < rand(1,10); $i++) { 
            // inicializamos el video categoria y categoria
            $videoCategoria = new VideoCategoria();
            $categoria = new Categoria();
            
            //recuperamos la categoria a partir de un ID
            $categoria = $this->em->getRepository(Categoria::class)->find(rand(1,10));
            $videoCategoria->setCategoriaId($categoria);

            // seteamos el video en categoria Video
            $videoCategoria->setVideoId($video);

            //persistimos
            $this->em->persist($videoCategoria);

            // ejecutamos la query, por ejemplo, el insertar. 
            $this->em->flush();
        }  */        
        return $this->render('video/index.html.twig', [
            'controller_name' => "la video es ".$video->getNombre(),
            'video' => $video,
            'mensage' => $this->oKKo
        ]);
     }
}
