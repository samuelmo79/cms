<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MenuCategoriaController extends AbstractController
{
    /**
     * @Route("/menu/categoria", name="menu_categoria")
     */
    public function index()
    {
        return $this->render('menu_categoria/index.html.twig', [
            'controller_name' => 'MenuCategoriaController',
        ]);
    }
}
