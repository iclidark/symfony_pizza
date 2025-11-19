<?php

namespace App\Twig\Components;

use App\Entity\CreditCard;
use App\Form\CreditCardType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class CreditCardForm extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp]
    public ?CreditCard $creditCard = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(CreditCardType::class, $this->creditCard);
    }
}
