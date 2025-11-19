<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private RequestStack $requestStack;
    private ProductRepository $productRepository;

    public function __construct(RequestStack $requestStack, ProductRepository $productRepository)
    {
        $this->requestStack = $requestStack;
        $this->productRepository = $productRepository;
    }

    public function add(int $productId): void
    {
        $cart = $this->getSession()->get('cart', []);

        if (!empty($cart[$productId])) {
            $cart[$productId]++;
        } else {
            $cart[$productId] = 1;
        }

        $this->getSession()->set('cart', $cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->getSession()->get('cart', []);

        if (!empty($cart[$productId])) {
            unset($cart[$productId]);
        }

        $this->getSession()->set('cart', $cart);
    }

    public function getCart(): array
    {
        $cart = $this->getSession()->get('cart', []);
        $cartWithData = [];

        foreach ($cart as $id => $quantity) {
            $cartWithData[] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity
            ];
        }

        return $cartWithData;
    }

    public function getTotal(): float
    {
        $total = 0;
        $cart = $this->getCart();

        foreach ($cart as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }

        return $total;
    }

    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }
}
