<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController {

    /**
     * @Route("/list",name="app_list")
     */
    public function list(WishRepository $WishRepo):Response{

        $wishList = $WishRepo->findAll();

        return $this->render("wish/list.html.twig", ["wishList" => $wishList]);
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
    public function detail(WishRepository $WishRepo, $id): Response
    {
        $wish = $WishRepo->find($id);

        return $this->render('wish/detail.html.twig', ['wish' => $wish]);
    }

}