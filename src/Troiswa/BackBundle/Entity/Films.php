<?php

namespace Troiswa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Films
 *
 * @ORM\Table(name="film")
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Entity\FilmRepository")
 */

class Films
{

    /**
     * @ORM\ManyToOne(targetEntity="Troiswa\BackBundle\Entity\Genres")
     */
    private $genre;


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=150)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDeRealisation", type="datetime")
     */
    private $dateDeRealisation;

    /**
     * @var float
     *
     * @ORM\Column(name="note", type="float")
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=150)
     */
    private $image;

    /** @Assert\Image(
     *     minWidth = 500,
     *     minWidthMessage="L'image doit faire plus de 500px de large.",
     *
     *     maxWidth = 1200,
     *     maxWidthMessage="L'image doit faire moins de 1200px de large.",
     *
     *     minHeight = 500,
     *     minHeightMessage="L'image doit faire plus de 500px de haut.",
     *
     *     maxHeight = 1200,
     *     maxHeightMessage="L'image doit faire moins de 1200px de haut.",
     *
     *     maxSize = "1M",
     *     maxSizeMessage="L'image ne doit pas dépasser 1Mo.",
     *
     *     mimeTypes={"image/png","image/jpg","image/jpeg"},
     *     mimeTypesMessage="L'image doit être au format JPG ou PNG."
     * )
     */
    private $fichier;

    /**
     * @return object
     */
    public function getFichier()
    {
        return $this->fichier;
    }

    /**
     * @param object $fichier
     * @return Acteurs
     */
    public function setFichier($fichier)
    {
        $this->fichier = $fichier;

        return $this;
    }


    /**
     * Get id
     *
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Film
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Film
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateDeRealisation
     *
     * @param \DateTime $dateDeRealisation
     * @return Film
     */
    public function setDateDeRealisation($dateDeRealisation)
    {
        $this->dateDeRealisation = $dateDeRealisation;

        return $this;
    }

    /**
     * Get dateDeRealisation
     *
     * @return \DateTime 
     */
    public function getDateDeRealisation()
    {
        return $this->dateDeRealisation;
    }

    /**
     * Set note
     *
     * @param float $note
     * @return Film
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return float 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Film
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;

    }

    public function displayImage()
    {
        return "images/films/".$this->image;
    }



    /**
     * Set genre
     *
     * @param \Troiswa\BackBundle\Entity\Genres $genre
     * @return Films
     */
    public function setGenre(\Troiswa\BackBundle\Entity\Genres $genre = null)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return \Troiswa\BackBundle\Entity\Genres 
     */
    public function getGenre()
    {
        return $this->genre;
    }

    public function upload(){

        if($this->fichier===null){
            return;
        }
        $nomImage=uniqid()."-".$this->fichier->getClientOriginalName();

        $this->fichier->move(
            __DIR__."/../../../../web/images/films",$nomImage
        );

        $this->image=$nomImage;

        $this->fichier=null;
    }
}
