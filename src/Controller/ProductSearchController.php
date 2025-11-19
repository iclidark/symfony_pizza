<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductSearchController extends AbstractController
{
    #[Route('/product/search', name: 'product_search')]
    public function __invoke(): Response
    {
        return $this->render('product_search/index.html.twig');
    }
}
