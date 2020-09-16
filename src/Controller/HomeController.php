<?php

namespace App\Controller;

use App\Entity\Artigo;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $artigos = $this->em->getRepository(Artigo::class)->findAll();

        $destaques = $this->em->getRepository(Artigo::class)->destaques();

        $maisPopulares = $this->em->getRepository(Artigo::class)->findBy(array(), array(
            'acessos' => 'DESC'
        ));

        return $this->render('home/index.html.twig', [
            'artigos' => $artigos,
            'destaques' => $destaques,
            'maisPopulares' => $maisPopulares,
        ]);
    }

    /**
     * @Route("/registro", name="registro", methods={"GET","POST"})
     */
    public function registro(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $senhaEncriptada = $encoder->encodePassword($user, $user->getSenhaPura());
            $user->setPassword($senhaEncriptada);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Cadastrado com sucesso');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('home/registro.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/artigo/{slug}", name="ver_artigo", methods={"GET"})
     */
    public function verArtigo(Artigo $artigo)
    {
        $contaAcesso = $this->em->getRepository(Artigo::class)->find($artigo);
        $contaAcesso->setAcessos($contaAcesso->getAcessos() + 1);
        $this->em->flush();

        return $this->render('home/verArtigo.html.twig', [
            'artigo' => $artigo,
        ]);
    }
}
