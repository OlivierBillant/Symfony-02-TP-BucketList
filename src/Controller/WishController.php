<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Repository\WishRepository;
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
     * @Route("/detail",name="app_detail")
     */
    public function detail():Response{
        return $this->render("wish/detail.html.twig");
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
        $em->persist($w);
        $em->flush();

        return $this->render('wish/list.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

/**
     * @Route("/afficher", name="app_display")
     */
    public function afficher(WishRepository $WishRepo): Response
    {
        dd($WishRepo->findAll());
    }

}