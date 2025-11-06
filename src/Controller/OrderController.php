<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/order/new', name: 'order_new')]
    public function new(SessionInterface $session, ProductRepository $productRepository, EntityManagerInterface $em): Response
    {
        $cart = $session->get('cart', []);

        if (empty($cart)) {
            return $this->redirectToRoute('product_list');
        }

        $order = new Order();

        foreach ($cart as $productId => $quantity) {
            $product = $productRepository->find($productId);

            if (!$product) {
                // Handle product not found, maybe remove from cart and add a flash message
                continue;
            }

            $orderItem = new OrderItem();
            $orderItem->setProduct($product);
            $orderItem->setQuantity($quantity);
            $order->addOrderItem($orderItem);

            // Update stock
            $newStock = $product->getStock() - $quantity;
            if ($newStock < 0) {
                // Handle insufficient stock
                $this->addFlash('error', 'Insufficient stock for ' . $product->getName());
                return $this->redirectToRoute('cart_index');
            }
            $product->setStock($newStock);
        }

        $em->persist($order);
        $em->flush();

        $session->set('cart', []);

        $this->addFlash('success', 'Order placed successfully!');

        return $this->redirectToRoute('product_list');
    }
}
