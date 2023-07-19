<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Categoria;

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
}
