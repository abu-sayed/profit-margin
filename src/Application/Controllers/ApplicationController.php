<?php

namespace Application\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Products\Services\ProductService;

class ApplicationController extends AbstractController
{

    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @Route("/", name="app_home_page")
     */
    public function index()
    {
        return $this->render('home_page.html.twig', ['title'=> 'Welcome to home page']);
    }
}
