<?php

namespace App\AdminBundle\Controller;

use App\Entity\Artigo;
use App\Form\ArtigoType;
use App\Repository\ArtigoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/artigo")
 */
class ArtigoController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @Route("/", name="artigo_index", methods={"GET"})
     */
    public function index(ArtigoRepository $artigoRepository): Response
    {
        return $this->render('@Admin/artigo/index.html.twig', [
            'artigos' => $artigoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="artigo_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $artigo = new Artigo();
        $form = $this->createForm(ArtigoType::class, $artigo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $artigo->setAutor($this->getUser());
            $entityManager->persist($artigo);
            $entityManager->flush();

            $this->addFlash('success', 'O Artigo foi cadastrado com sucesso.');
            return $this->redirectToRoute('artigo_index');
        }

        return $this->render('@Admin/artigo/new.html.twig', [
            'artigo' => $artigo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="artigo_show", methods={"GET"})
     */
    public function show(Artigo $artigo): Response
    {
        return $this->render('@Admin/artigo/show.html.twig', [
            'artigo' => $artigo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="artigo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Artigo $artigo): Response
    {
        $form = $this->createForm(ArtigoType::class, $artigo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('artigo_index');
        }

        return $this->render('@Admin/artigo/edit.html.twig', [
            'artigo' => $artigo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="artigo_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Artigo $artigo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artigo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($artigo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('artigo_index');
    }
}
