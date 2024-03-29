<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('index.html.twig');
    }
    
    /**
     * @Route("/about", name="about")
     */
    public function about() 
    {
        return $this->render('about.html.twig');
    }
    
}