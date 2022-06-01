<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController {

    /**
     * @Route("/",name="app_home")
     */
    public function home():Response{
        $a = "Accueil";
        return $this->render("main/home.html.twig", ["titre"=>$a]);
    }


     /**
     * @Route("/aboutus",name="app_aboutus")
     */
    public function aboutus():Response{
        return $this->render("main/aboutus.html.twig");
    }


}