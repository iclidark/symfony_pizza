<?php

namespace App\Controller;

use App\Form\Type\ProductAutocompleteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(): Response
    {
        $form = $this->createForm(ProductAutocompleteType::class);

        return $this->render('search/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
