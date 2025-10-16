<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Image;
use App\Enum\ProductStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 5; $i++) {
            // ✅ On crée d'abord le produit
            $product = new Product();
            $product->setName("Pizza $i");
            $product->setPrice(9.99 + $i);
            $product->setDescription("Délicieuse pizza n°$i avec des ingrédients frais.");
            $product->setStock(10 + $i);
            $product->setStatus(ProductStatus::AVAILABLE->value); // ✅ Enum (si ta méthode setStatus accepte bien une Enum)

            // ✅ Ensuite on crée l'image associée
            $image = new Image();
            $image->setUrl("pizza$i.jpg");
            $image->setProduct($product); // ici $product est bien défini

            // Relation inverse si tu veux :
            // $product->addImage($image);

            $manager->persist($product);
            $manager->persist($image);
        }

        $manager->flush();
    }
}