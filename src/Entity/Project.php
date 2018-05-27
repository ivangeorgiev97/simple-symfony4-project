<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $project_name;
    
    /**
     * @ORM\Column(type="text")
     */
    private $description;
    
    public function getId() {
        return $this->id;
    }

    public function getProject_name() {
        return $this->project_name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setProject_name($project_name) {
        $this->project_name = $project_name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
}
