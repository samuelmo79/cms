<?php


namespace App\AdminBundle\Controller;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
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
    public function index(EntityManagerInterface $entityManager)
    {
        $contaUsuarios = $entityManager->getRepository(User::class)->contaUsuario();
        return [
            'contaUsuarios' => $contaUsuarios,
        ];
    }
}