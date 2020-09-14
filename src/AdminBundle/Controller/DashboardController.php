<?php


namespace App\AdminBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @return Response
     * @Route("/", name="index_dashboard")
     * @Template("@Admin/dashboard/index.html.twig")
     */
    public function index()
    {
        return [];
    }
}