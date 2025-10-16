<?php
namespace App\Enum;

enum ProductStatus: string
{
    case AVAILABLE = 'disponible';
    case OUT_OF_STOCK = 'rupture';
    case PREORDER = 'précommande';
}
