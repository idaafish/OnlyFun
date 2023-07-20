<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Categoria;
use Symfony\Component\HttpFoundation\Request;

class CategoriaController extends AbstractController
{
    private $em;
    public $oKKo = true;
    //Constructor
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/categoria', name: 'categoria')]
    public function index(): Response
    {
        // creamos obj Categoria
        $categoria = new Categoria();
        $categoria->setNombre("");


        return $this->render('categoria/index.html.twig', [
            'controller_name' => 'CategoriaController',
            'categoria' => $categoria,
            'mensage' => $this->oKKo
        ]);
    }

    #[Route('/crearCategoria', name: 'crearCategoria')]
    public function new(): Response
    {
        // creamos obj Categoria
        $categoria = new Categoria();

        //rellenamos valores
        $variableRandom =rand(1,5000000);
        $categoria->setNombre("Categoria".$variableRandom);
     

        //persistimos
        $this->em->persist($categoria);


        // ejecutamos la query, por ejemplo, el insertar. 
        $this->em->flush();

       
        return $this->render('categoria/index.html.twig', [
            'controller_name' => "Guarda la Categoria  ".$categoria->getNombre(),
            'categoria' => $categoria,
            'mensage' => $this->oKKo
       ]);
    }

    
    #[Route('/mostrarCategoria/{request,id}', name: 'mostrarCategoria')]
    public function show(Request $request): Response
    {
        $idRequest=$request->request->get('id');
        // creamos obj Categoria
        $categoria = new Categoria();

        //recuperamos el categoria
        $categoria = $this->em->getRepository(Categoria::class)->find($idRequest);

        // validamos que citas venga relleno
        if (!$categoria) {
            throw $this->createNotFoundException('No se encontró el usuario con el ID: '.$idRequest);
        } 

       
        return $this->render('categoria/index.html.twig', [
            'controller_name' => "Guarda el Categoria  ".$categoria->getNombre(),
            'categoria' => $categoria,
            'mensage' => $this->oKKo
       ]);
    }

    #[Route('/cambiarCategoria/{request,id}', name: 'cambiarCategoria')]
    public function update(Request $request): Response
    {
        $idRequest=$request->request->get('id');
        // creamos obj Categoria
        $categoria = new Categoria();

        //recuperamos el categoria
        $categoria = $this->em->getRepository(Categoria::class)->find($idRequest);

        // validamos que citas venga relleno
        if (!$categoria) {
            throw $this->createNotFoundException('No se encontró el categoria con el ID: '.$idRequest);
        } else {

            //modificamos
            $categoria->setNombre("Nombre MODIFICADO");

            //persistimos
            $this->em->persist($categoria);
    
              // ejecutamos la query, por ejemplo, el insertar. 
            $this->em->flush();
        }
       
        return $this->render('categoria/index.html.twig', [
            'controller_name' => "Guarda el Categoria  ".$categoria->getNombre(),
            'categoria' => $categoria,
            'mensage' => $this->oKKo
       ]);
    }

    #[Route('/borrarCategoria/{request,id}', name: 'borrarCategoria')]
    public function delete(Request $request): Response
    {
        $idRequest=$request->request->get('id');
        // creamos obj Categoria
        $categoria = new Categoria();

        //recuperamos el categoria
        $categoria = $this->em->getRepository(Categoria::class)->find($idRequest);

        //eliminamos la cita seleccionada
        $this->em->remove($categoria);
        $this->em->flush();

        // validamos que citas venga relleno
        if (!$categoria) {
            throw $this->createNotFoundException('No se encontró el usuario con el ID: '.$idRequest);
        } 

       
        return $this->render('categoria/index.html.twig', [
            'controller_name' => "Guarda el Categoria  ".$categoria->getNombre(),
            'categoria' => $categoria,
            'mensage' => $this->oKKo
       ]);
    }
}
