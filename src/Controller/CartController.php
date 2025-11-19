<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_index')]
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cartService->getCart(),
            'total' => $cartService->getTotal(),
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(int $id, CartService $cartService, Request $request): Response
    {
        $cartService->add($id);

        if ($request->isXmlHttpRequest()) {
            return $this->json([
                'count' => count($cartService->getCart()),
            ]);
        }

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove(int $id, CartService $cartService, Request $request): Response
    {
        $cartService->remove($id);

        if ($request->isXmlHttpRequest()) {
            return $this->json([
                'count' => count($cartService->getCart()),
                'total' => $cartService->getTotal(),
                'productId' => $id,
            ]);
        }

        return $this->redirectToRoute('cart_index');
    }
}
