<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/cart/checkout', name: 'cart_checkout')]
    public function checkout(CartService $cartService, EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('warning', 'You need to be logged in to checkout.');
            return $this->redirectToRoute('app_login');
        }

        $cart = $cartService->getCart();

        if (empty($cart)) {
            return $this->redirectToRoute('cart_index');
        }

        $order = new Order();
        $order->setUser($user);
        $order->setCreatedAt(new \DateTimeImmutable());

        $total = 0;
        foreach ($cart as $item) {
            $orderItem = new OrderItem();
            $orderItem->setProduct($item['product']);
            $orderItem->setQuantity($item['quantity']);
            $orderItem->setPrice($item['product']->getPrice());
            $order->addOrderItem($orderItem);
            $total += $item['product']->getPrice() * $item['quantity'];
        }

        $order->setTotal($total);

        $entityManager->persist($order);
        $entityManager->flush();

        $this->addFlash('success', 'Your order has been placed successfully.');

        return $this->redirectToRoute('cart_index');
    }
}
