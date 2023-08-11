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
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
        
        //TODO recuperar categorias y usuarios por video
        
        $videoVista = new VideoViewModel(
            $video->getId(),
            $video->getNombre(),
            $video->getUrl(),
            $video->getDescripcion(),
            "categoria 1, categoria 2",
            "usuario 1"
        );

        return $this->render('video/index.html.twig', [
            'controller_name' => "la video es ".$videoVista->getNombre(),
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
        
        // recuperamos las cayegorias
        $categorias = $this->findCategoriasPersonalizadas($video->getId());

        // Ahora puedes convertir los resultados en un array de categorías si es necesario
        $categoriasArray = [];
        $categoriasString ="";
        foreach ($categorias as $categoria) {
            $categoriasArray[] = [
                'id' => $categoria->getId(),
                'nombre' => $categoria->getNombre(),
                // Otros campos de la entidad que desees incluir en el array

            ];
            $categoriasString = $categoriasString+" "+$categoria->getNombre()+ " ,";
        } 

        $videoVista = new VideoViewModel(
           $video->getId(),
           $video->getNombre(),
           $video->getUrl(),
           $video->getDescripcion(),
           $categoriasArray[],
           "usuario 1"
        );
 
        
        return $this->render('video/index.html.twig', [
            'controller_name' => "Guarda el Video  ".$videoVista->getNombre(),
            'video' => $videoVista,
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
        
        $videoVista = new VideoViewModel(
           $video->getId(),
           $video->getNombre(),
           $video->getUrl(),
           $video->getDescripcion(),
           "categoria 1, categoria 2",
           "usuario 1"
        );

        return $this->render('video/index.html.twig', [
            'controller_name' => "Guarda el Video  ".$videoVista->getNombre(),
            'video' => $videoVista,
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

        //TODO recuperamos las videoCategorias y las eliminamos
        
        //eliminamos la cita seleccionada
        $this->em->remove($video);
        $this->em->flush();
 
        // validamos que citas venga relleno
        if (!$video) {
            throw $this->createNotFoundException('No se encontró el video con el ID: '.$idRequest);
        } 
 
        $videoVista = new VideoViewModel(0,"","","","",""); 
        
        return $this->render('video/index.html.twig', [
            'controller_name' => "Guarda el Video  ".$videoVista->getNombre(),
            'video' => $videoVista,
            'mensage' => $this->oKKo
        ]);
    }

    public function findCategoriasPersonalizadas($someValue)
    {
        //SELECT u.* from video_categoria u WHERE u.video_Id = 25
        $qb = $this->em->createQueryBuilder();
        $qb->select('u.categoria_id')
           ->from('video_categoria', 'u')
           ->where('u.videoId = :videoId')
           ->setParameter('video_Id', 1);
        
    return $qb->getQuery()->getSingleResult();

    }
}
