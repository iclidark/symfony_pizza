<?php 

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/burger', name: 'burger_')]
class BurgerController extends AbstractController
{
    #[Route('/liste', name: 'liste')]
    public function liste(): Response
    {
        $burgers = [
            [
                'id' => 1,
                'name' => 'Cheeseburger',
                'description' => "Un burger",
            ],
            [
                'id' => 2,
                'name' => 'Bacon Burger',
                'description' => "Miam",
            ],
            [
                'id' => 3,
                'name' => 'Veggie Burger',
                'description' => "Cool",
            ],
        ];
 
        return $this->render('burger/liste_burger.html.twig', [
            'burgers' => $burgers,
        ]);
    }

    #[Route('/show/{id}', name: 'detail')]
    public function detail(int $id): Response
    {
        $burgers = [
            1 => [
                'name' => 'Cheeseburger',
                'description' => 'Un délicieux cheeseburger avec du cheddar fondant.',
                'price' => 5.99,
                'image' => 'burger.jpg'
            ],
            2 => [
                'name' => 'Bacon Burger',
                'description' => 'Burger avec bacon croustillant et sauce BBQ.',
                'price' => 6.99,
                'image' => 'burger.jpg'
            ],
            3 => [
                'name' => 'Veggie Burger',
                'description' => 'Burger végétarien avec galette de légumes maison.',
                'price' => 5.49,
                'image' => 'burger.jpg'
            ]
        ];

    
        $burger = $burgers[$id];

        return $this->render('burger/detail.html.twig', [
            'burger' => $burger
        ]);
    }
}