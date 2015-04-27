<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Troiswa\BackBundle\Entity\Acteurs;
use Symfony\Component\Validator\Constraints\NotBlank;


class ActeursController extends Controller
{
    public function indexAction(Request $request){

        $em = $this->getDoctrine()->getManager(); // récupération de doctrine

        //$tousLesActeurs = $em->getRepository("TroiswaBackBundle:Acteurs")->findAll();   // = fetchAll dans la class Acteurs (idem Model)
        //$em    = $this->get('doctrine.orm.entity_manager');

        $dql   = "SELECT a FROM TroiswaBackBundle:Acteurs a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $paginationActeurs = $paginator->paginate(
            $query,
            $request->query->get('page', 1)/*page number*/,
            2/*limit per page*/
        );

        return $this->render("TroiswaBackBundle:Acteurs:index.html.twig", ["acteurs"=>$paginationActeurs]);
    }

    public function voirAction($id){

        $em=$this->getDoctrine()->getManager();
        $lActeur = $em->getRepository("TroiswaBackBundle:Acteurs")->find($id);

        return $this->render("TroiswaBackBundle:Acteurs:unacteur.html.twig", ["acteur"=>$lActeur]);
    }

    public function creerAction(Request $request){
        $nouveauActeur = new Acteurs();

        $form=$this->createFormBuilder($nouveauActeur)
            ->add("prenom","text")
            ->add("nom","text")
            ->add('sexe', 'choice', array(
                'choices'   => array('1' => 'Masculin', '0' => 'Féminin'),
                'required'  => true,
            ))
            ->add("biographie","textarea")
            ->add('dateNaissance', 'date', array(
                'years' => range(date('Y')-100,date('Y')),
                'format' => 'dd-MM-yyyy',
            ))
            ->add("ville","text")
            ->add("fichier","file", ["constraints"=>new NotBlank(["message"=>"Attention, image obligatoire!"])])
            ->add("ajouter","submit")
            ->getForm();                     // RECUPERE LE FORMULAIRE


        if ($request->isMethod("POST"))
        {
            $form->submit($request);     // je le remplis avec les info tapées dans le formulaire

            if($form->isValid())
            {
                $em=$this->getDoctrine()->getManager();

                $nouveauActeur->upload();

                $em->persist($nouveauActeur);        // SURVEILLE L'OBJET

                $em->flush();       // ENREGISTRE DANS LA BASE

                $sessions= $request->getSession();

                $sessions->getFlashBag()->add("success_acteur", "L'acteur a bien été ajouté");

                return $this->redirect($this->generateUrl("troiswa_back_acteurs"));
            }
        }
        return $this->render("TroiswaBackBundle:Acteurs:creer.html.twig",['formGenre'=>$form->createView()]);
    }

    public function modifierAction($id, Request $request){

        $em=$this->getDoctrine()->getManager();
        $acteur = $em->getRepository("TroiswaBackBundle:Acteurs")->find($id);

        //die(var_dump($acteur));

        $form=$this->createFormBuilder($acteur)
            ->add("prenom","text")
            ->add("nom","text")
            ->add('sexe', 'choice', array(
                'choices'   => array('1' => 'Masculin', '0' => 'Féminin'),
                'required'  => true,
            ))
            ->add("biographie","textarea")
            ->add('dateNaissance', 'date', array(
                'years' => range(date('Y')-100,date('Y')),
                'format' => 'dd-MM-yyyy',
            ))
            ->add("ville","text")
            ->add("fichier","file", ["constraints"=>new NotBlank(["message"=>"Attention, image obligatoire!"])])
            ->add("ajouter","submit")
            ->getForm();                   // RECUPERE LE FORMULAIRE


        if ($request->isMethod("POST"))
        {
            $form->submit($request);     // je le remplis avec les info tapees dans le formulaire

            if($form->isValid())
            {
                $acteur->upload();

                $em->flush();       // ENREGISTRE DANS LA BASE

                $sessions= $request->getSession();

                $sessions->getFlashBag()->add("success_genre", "Le genre a bien été créé");

                return $this->redirect($this->generateUrl("troiswa_back_acteurs"));
            }
}
        return $this->render("TroiswaBackBundle:Acteurs:modifier.html.twig", ['formGenre'=>$form->createView()]);
    }

    public function supprimerAction($id, Request $request)   // $_POST et $_GET et autres iformations supplémentaires
    {
        $em=$this->getDoctrine()->getManager();
        $unActeur=$em->getRepository("TroiswaBackBundle:Acteurs")->find($id);  // Acteurs=class ENRGISTRE DANS LA BASE

        $em->remove($unActeur);
        $em->flush();                              // ENRGISTRE DANS LA BASE

        $sessions=$request->getSession();
        $sessions->getFlashBag()->add("delete_acteur","L'acteur a bien été supprimé");

        return $this->redirect($this->generateUrl("troiswa_back_acteurs"));
    }



}
