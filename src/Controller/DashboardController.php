<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'admin_dashboard')]
    public function index(ProductRepository $productRepository, OrderRepository $orderRepository): Response
    {
        // Total number of products per category
        $productsByCategory = $productRepository->countByCategory();

        // The 5 last orders
        $latestOrders = $orderRepository->findBy([], ['createdAt' => 'DESC'], 5);

        // Product availability ratio
        $availabilityRatio = $productRepository->getAvailabilityRatio();

        // Total amount of sales made
        $salesByMonth = $orderRepository->getTotalSalesByMonth();

        return $this->render('admin/dashboard.html.twig', [
            'productsByCategory' => $productsByCategory,
            'latestOrders' => $latestOrders,
            'availabilityRatio' => $availabilityRatio,
            'salesByMonth' => $salesByMonth,
        ]);
    }
}
