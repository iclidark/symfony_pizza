<?php

namespace App\Controller;

use App\Entity\CreditCard;
use App\Form\CreditCardType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CreditCardController extends AbstractController
{
    #[Route('/credit/card', name: 'app_credit_card')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $creditCard = new CreditCard();
        $form = $this->createForm(CreditCardType::class, $creditCard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $creditCard->setUser($this->getUser());
            $entityManager->persist($creditCard);
            $entityManager->flush();

            return $this->redirectToRoute('app_credit_card');
        }

        return $this->render('credit_card/index.html.twig', [
            'form' => $form,
        ]);
    }
}
