<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagosController extends AbstractController
{
    #[Route('/pagos', name: 'app_pagos')]
    public function index(): Response
    {
        return $this->render('pagos/index.html.twig', [
            'controller_name' => 'PagosController',
        ]);
    }
}
