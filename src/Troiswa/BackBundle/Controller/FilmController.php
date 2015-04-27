<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Troiswa\BackBundle\Entity\Films;

class FilmController extends Controller
{

    public function allFilmsAction()
    {

        // maintenant a partir de la BDD

        // $em = EntityManager  = $connexion $em est dans la doc officielle

        $em = $this->getDoctrine()->getManager(); // récupération de doctrine

        $allFilms = $em->getRepository("TroiswaBackBundle:Films")->findAll();

        return $this->render("TroiswaBackBundle:Films:index.html.twig",['allFilms'=>$allFilms]);

    }


    public function informationAction($id)
    {
        $em = $this->getDoctrine()->getManager(); // récupération de doctrine

        $unFilm = $em->getRepository("TroiswaBackBundle:Films")->find($id);   // = unbufered dans la classe Film rep Entity

        //die(var_dump($unActeur));

        return $this->render("TroiswaBackBundle:Films:index.html.twig",['unFilm'=>$unFilm]);
        // Films = nom du dossier des views    infoFilm.html.twig = nom du fichier html que nous avons crée

    }

    public function creerAction(Request $request){
        $nouveauFilm = new Films();

        $form=$this->createFormBuilder($nouveauFilm)
            ->add("titre","text")
            ->add("genre","entity",
                [
                    "class"=>"TroiswaBackBundle:Genres",
                    "property"=>"type"
                ])
            ->add('description', 'textarea')
            ->add('dateDeRealisation', 'date', array(
                'years' => range(date('Y')-100,date('Y')),
                'format' => 'dd-MM-yyyy',
            ))
            ->add("note","textarea")
            ->add("fichier","file", ["constraints"=>new NotBlank(["message"=>"Attention, image obligatoire!"])])
            ->add("ajouter","submit")
            ->getForm();                     // RECUPERE LE FORMULAIRE


        if ($request->isMethod("POST"))
        {
            $form->submit($request);     // je le remplis avec les info tapées dans le formulaire

            if($form->isValid())
            {
                $em=$this->getDoctrine()->getManager();

                $nouveauFilm->upload();

                $em->persist($nouveauFilm);        // SURVEILLE L'OBJET

                $em->flush();       // ENREGISTRE DANS LA BASE

                $sessions= $request->getSession();

                $sessions->getFlashBag()->add("success_films", "Le film a bien été ajouté");

                return $this->redirect($this->generateUrl("troiswa_back_films"));
            }
        }
        return $this->render("TroiswaBackBundle:Films:creer.html.twig",['formGenre'=>$form->createView()]);
    }

    public function modifierAction($id, Request $request){

        $em=$this->getDoctrine()->getManager();
        $film = $em->getRepository("TroiswaBackBundle:Films")->find($id);


        $form=$this->createFormBuilder($film)
            ->add("titre","text")
            ->add("genre","entity",
                [
                    "class"=>"TroiswaBackBundle:Genres",
                    "property"=>"type"
                ])
            ->add('description', 'textarea')
            ->add('dateDeRealisation', 'date', array(
                'years' => range(date('Y')-100,date('Y')),
                'format' => 'dd-MM-yyyy',
            ))
            ->add("note","textarea")
            ->add("fichier","file")
            ->add("ajouter","submit")
            ->getForm();                    // RECUPERE LE FORMULAIRE


        if ($request->isMethod("POST"))
        {
            $form->submit($request);     // je le remplis avec les info tapees dans le formulaire

            if($form->isValid())
            {
                $film->upload();

                $em->flush();       // ENREGISTRE DANS LA BASE

                $sessions= $request->getSession();

                $sessions->getFlashBag()->add("success_film", "Le film a bien été créé");

                return $this->redirect($this->generateUrl("troiswa_back_films"));
            }
        }
        return $this->render("TroiswaBackBundle:Films:modifier.html.twig", ['formGenre'=>$form->createView()]);
    }

    public function supprimerAction($id, Request $request)   // $_POST et $_GET et autres iformations supplémentaires
    {
        $em=$this->getDoctrine()->getManager();
        $unFilm=$em->getRepository("TroiswaBackBundle:Films")->find($id);  // Acteurs=class ENRGISTRE DANS LA BASE

        $em->remove($unFilm);
        $em->flush();                              // ENRGISTRE DANS LA BASE

        $sessions=$request->getSession();
        $sessions->getFlashBag()->add("delete_film","Le filma bien été supprimé");

        return $this->redirect($this->generateUrl("troiswa_back_films"));
    }
}