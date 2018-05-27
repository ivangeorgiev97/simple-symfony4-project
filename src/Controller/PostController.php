<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\Common\Annotations\Annotation;


class PostController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Post::class);
        
        $paginator = $this->get('knp_paginator');
        
        $query = $repository->findAll();
        
        $posts =  $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                5
        );     
                
        return $this->render('blog/index.html.twig', array(
            'posts' => $posts,
        ));
    }
    
    /**
     * @Route("/blog/post/{id}", name="blog_post_show")
     */
    public function show(Post $post) 
    {   
        return $this->render('blog/show.html.twig', array(
            'post' => $post,
        ));
    }
    
    /**
     * @Route("/blog/category/{category_id}", name="blog_category_show")
     */
    public function showByCategory($category_id, Request $request) 
    {   
        $repository = $this->getDoctrine()->getRepository(Post::class);
        
        $paginator = $this->get('knp_paginator');
        
        $query = $repository->findBy(array('category' => $category_id), array('created_at' => 'DESC'));
        
        $posts =  $paginator->paginate(
                $query,
                $request->query->getInt('page', 1),
                5
        );      
        
        return $this->render('blog/index.html.twig', array(
            'posts' => $posts,
        ));
    }
    
    public function createSearchForm() 
    {
        $form = $this->createFormBuilder(null)
                ->add('search', TextType::class)
                ->getForm();
        
        return $this->render('searchForm.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    /**
     * @Route("/search/results/", name="blog_search_results")
     */
    public function searchByName(Request $request) 
    {
        $repository = $this->getDoctrine()->getRepository(Post::class);
        
        $paginator = $this->get('knp_paginator');
        
        $submittedToken = $request->query->get('token');
        
       if ($this->isCsrfTokenValid('search-item', $submittedToken)) {
            $title = $request->query->get('search');     
                 
            $query = $repository->findAllByTitle($title); 

            $posts =  $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
            );

            return $this->render('blog/searchResults.html.twig', array(
                'posts' => $posts,
            ));
       }
        
        
        return $this->redirectToRoute("blog");
    }
}
