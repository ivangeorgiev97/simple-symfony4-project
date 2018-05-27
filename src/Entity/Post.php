<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{   
     /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;
    
    /**
     * @ORM\Column(type="text")
     */
    private $content;
    
    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $slug;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updated_at;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="posts")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;
       
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="posts")
     */
    private $comments;
           
        
    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }
    
    public function setTitle($title) {
        $this->title = $title;
    }

    public function setContent($content) {
        $this->content = $content;
    }
    
    public function getSlug() {
        return $this->slug;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }
    
    public function getCreated_at(): \DateTime {
        return $this->created_at;
    }

    public function getUpdated_at(): \DateTime {
        return $this->updated_at;
    }

    public function setCreated_at(\DateTime $created_at) {
        $this->created_at = $created_at;
    }

    public function setUpdated_at(\DateTime $updated_at) {
        $this->updated_at = $updated_at;
    }

            
    /**
     * @return Collection|Comment[]
     */
    public function getComments()
    {
        return $this->comments;
    }
}
