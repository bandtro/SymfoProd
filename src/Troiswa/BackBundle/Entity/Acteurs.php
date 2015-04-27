<?php

namespace Troiswa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acteurs
 *
 * @ORM\Table(name="acteur")
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Entity\ActeursRepository")
 */

class Acteurs
{
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
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "2",
     *      max = "50",
     *      minMessage = "Votre nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre nom ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="prenom", type="string", length=50)
     */
    private $prenom;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "3",
     *      max = "100",
     *      minMessage = "Votre nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre nom ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="nom", type="string", length=100)
     */
    private $nom;

    /**
     * @var boolean
     *
     * @Assert\Choice(choices = {"0", "1"}, message = "Choisissez un genre valide.")
     *
     * @ORM\Column(name="sexe", type="boolean")
     */
    private $sexe;


    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = "300",
     *      maxMessage = "La biographie ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="biographie", type="text")
     */
    private $biographie;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date")
     */
    private $dateNaissance;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "2",
     *      max = "50",
     *      minMessage = "La ville doit faire au moins {{ limit }} caractères",
     *      maxMessage = "La ville ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var object
     *
     * @Assert\Image(
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
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Acteurs
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Acteurs
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set biographie
     *
     * @param string $biographie
     * @return Acteurs
     */
    public function setBiographie($biographie)
    {
        $this->biographie = $biographie;

        return $this;
    }

    /**
     * Get biographie
     *
     * @return string 
     */
    public function getBiographie()
    {
        return $this->biographie;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     * @return Acteurs
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime 
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Acteurs
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Acteurs
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

    /**
     * Set sexe
     *
     * @param boolean $sexe
     * @return Acteurs
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return boolean 
     */
    public function getSexe()
    {
        return $this->sexe;
    }


    public function displayImage()
    {
        return $this->getImageFolder()."/".$this->image;
    }

    public function upload(){

        if($this->fichier===null){
            return;
        }
        $nomImage=uniqid()."-".$this->fichier->getClientOriginalName();

        $this->fichier->move(
            __DIR__."/../../../../web/".$this->getImageFolder(),$nomImage
        );

        $this->image=$nomImage;

        $this->fichier=null;
    }

    private function getImageFolder(){

        return "images/acteurs";
    }

}
