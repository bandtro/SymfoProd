<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction(){

        $em=$this->getDoctrine()->getManager();

        $nbDeFilm=$em->getRepository("TroiswaBackBundle:Films")->getNombreDeFilm();

        $nbActeursr=$em->getRepository("TroiswaBackBundle:Films")->getNombreDacteurs();

        $maleFemaleRatio=$em->getRepository("TroiswaBackBundle:Films")->getMaleFemaleActorsNumber();

        $nbFilmsPerGenre=$em->getRepository("TroiswaBackBundle:Films")->getNombreDeFilmPerGenre();



        return $this->render("TroiswaBackBundle:Main:index.html.twig");
    }

}
