<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/wish")
 */
class WishController extends AbstractController
{


    /**
     * @Route("/", name="app_wish_index", methods={"GET"})
     */
    public function index(WishRepository $wishRepository): Response
    {
        return $this->render('wish/index.html.twig', [
            'wishes' => $wishRepository->findAll(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/new", name="app_new_wish", methods={"GET", "POST"})
     */
    public function new(Request $request, WishRepository $wishRepository): Response
    {
        $wish = new Wish();
        $form = $this->createForm(WishType::class, $wish);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $wishRepository->add($wish, true);
            // Ajouter un message de confirmation
            $this->addFlash('success', 'Voeux ajouté');
            return $this->redirectToRoute('app_wish_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('wish/new.html.twig', [
            'wish' => $wish,
            'form' => $form,
        ]);
    }

     /**
     * @Route("/liste",name="app_liste", methods={"GET"})
     */
    public function liste(WishRepository $wishRepository): Response
    {
        return $this->render("wish/liste.html.twig", ["wishList" => $wishRepository->findBy(['isPublished' => true], ['dateCreated' => 'ASC'])]);
        // return $this->render("wish/liste.html.twig", ["wishList" => $wishRepository->findOneByIdJoinedToCategory()]);
    }


    /**
     * @Route("/{id}", name="app_wish_show", methods={"GET"})
     */
    public function show(Wish $wish): Response
    {
        return $this->render('wish/show.html.twig', [
            'wish' => $wish,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_wish_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Wish $wish, WishRepository $wishRepository): Response
    {
        $form = $this->createForm(WishType::class, $wish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wishRepository->add($wish, true);
            // Ajouter un message de confirmation
            $this->addFlash('success', 'Voeux modifié');
            return $this->redirectToRoute('app_wish_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('wish/edit.html.twig', [
            'wish' => $wish,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_wish_delete", methods={"POST"})
     */
    public function delete(Request $request, Wish $wish, WishRepository $wishRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $wish->getId(), $request->request->get('_token'))) {
            $wishRepository->remove($wish, true);
        }

        return $this->redirectToRoute('app_wish_index', [], Response::HTTP_SEE_OTHER);
    }



    /**
     * @Route("/add", name="app_add")
     */
    public function add(EntityManagerInterface $em): Response
    {
        $w = new Wish();
        $w->setTitle("Souhait 1");
        $w->setDescription("Blablablabla");
        $w->setAuthor("Auteur1");
        $w->setDateCreated(new \DateTime());
        $em->persist($w);
        $em->flush();

        return $this->render('wish/add.html.twig');
    }


    /**
     * @Route("/detail", name="app_detail")
     */
    public function detail(WishRepository $WishRepo, Request $request): Response
    {
        $id = $request->query->get('id');
        var_dump($id);
        $wish = $WishRepo->find($id);

        return $this->render('wish/detail.html.twig', ['wish' => $wish]);
    }
}
