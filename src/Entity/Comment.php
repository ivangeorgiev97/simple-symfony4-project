<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $comment_content;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="comments")
     * @ORM\JoinColumn(nullable=true)
     */
    private $post;

    public function getPost(): Post
    {
        return $this->post;
    }

    public function setPost(Post $post)
    {
        $this->post = $post;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getComment_content() {
        return $this->comment_content;
    }

    public function setComment_content($comment_content) {
        $this->comment_content = $comment_content;
    }
}
