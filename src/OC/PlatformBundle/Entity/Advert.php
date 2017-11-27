<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Advert
 *
 * @ORM\Table(name="advert")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\AdvertRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Advert
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime",nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;


    /**
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = true;

    /**
     * Get id
     *
     * @return int
     */



    /**
     * @ORM\OneToOne(targetEntity="OC\PlatformBundle\Entity\Image", cascade={"persist"})
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="OC\PlatformBundle\Entity\Category", cascade={"persist"})
     */
    private $categories;


    /**
     * @ORM\ManyToMany(targetEntity="OC\PlatformBundle\Entity\Application", cascade={"persist"})
     */
    private $applications;


    /**
     * @ORM\Column(name="nb_applications", type="integer")
     */
    private $nbApplications=0;


    /**
    * @ORM\Column(name="updated_at", type="datetime", nullable=true)
    */
    private $updatedAt;




    public function __construct()
    {
        $this->date         = new \Datetime();

        $this->categories   = new ArrayCollection();

        $this->applications = new ArrayCollection();
    }


    public function increaseApplication()
   {
      $this->nbApplications++;
    }


    public function decreaseApplication()
    {
       $this->nbApplications--;
    }

    // Notez le singulier, on ajoute une seule catégorie à la fois

    public function addCategory(Category $category)

    {

        // Ici, on utilise l'ArrayCollection vraiment comme un tableau

        $this->categories[] = $category;

    }


    public function removeCategory(Category $category)

    {
      // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
      $this->categories->removeElement($category);
    }


    // Notez le pluriel, on récupère une liste de catégories ici !

    public function getCategories()
    {
       return $this->categories;
     }



    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Advert
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Advert
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
     * Set author
     *
     * @param string $author
     *
     * @return Advert
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Advert
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Advert
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set image
     *
     * @param \OC\PlatformBundle\Entity\Image $image
     *
     * @return Advert
     */
    public function setImage(\OC\PlatformBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \OC\PlatformBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return mixed
     */
    public function getNbApplications()
    {
        return $this->nbApplications;
    }

    /**
     * @param mixed $nbApplications
     */
    public function setNbApplications($nbApplications)
    {
        $this->nbApplications = $nbApplications;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return ArrayCollection
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * @param ArrayCollection $applications
     */
    public function setApplications($applications)
    {
        $this->applications = $applications;
    }

    public function updateDate()
    {
        $this->setUpdateAt(new \Datetime());
    }

}
