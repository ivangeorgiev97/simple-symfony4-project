<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(min=3)
     */
    private $category_name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="category")
     */
    private $posts;

    public function __construct() {
        $this->posts = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function getCategoryName() {
        return $this->category_name;
    }

    public function getCategory_name() { // 
        return $this->category_name;
    }

    public function setCategoryName($category_name) {
        $this->category_name = $category_name;
    }

    public function setCategory_name($category_name) {
        $this->category_name = $category_name;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts() {
        return $this->posts;
    }

}
