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
        
            // ✅ On crée d'abord le produit
            $product = new Product();
            $product->setName("Pizza margharita");
            $product->setPrice(9.50);
            $product->setDescription("Délicieuse pizza margharita avec des ingrédients frais.");
            $product->setStock(10);
            $product->setStatus(ProductStatus::AVAILABLE->value); // ✅ Enum (si ta méthode setStatus accepte bien une Enum)

            // ✅ On crée d'abord le produit
            $product2 = new Product();
            $product2->setName("Pizza 3fromage");
            $product2->setPrice(12.50);
            $product2->setDescription("Délicieuse pizza 3 fromages avec des ingrédients frais.");
            $product2->setStock(10);
            $product2->setStatus(ProductStatus::AVAILABLE->value); // ✅ Enum (si ta méthode setStatus accepte bien une Enum)

            // ✅ On crée d'abord le produit
            $product3 = new Product();
            $product3->setName("Pizza orientale");
            $product3->setPrice(12.50);
            $product3->setDescription("Délicieuse pizza orientale avec des ingrédients frais.");
            $product3->setStock(10);
            $product3->setStatus(ProductStatus::AVAILABLE->value); // ✅ Enum (si ta méthode setStatus accepte bien une Enum)



            // ✅ Ensuite on crée l'image associée
            $image = new Image();
            $image->setUrl("/images/margharita.jpg");
            $product->setImage($image); // ici $image est bien défini

            $image2 = new Image();
            $image2->setUrl("/images/3fromage.jpg");
            $product2->setImage($image2); // ici $image est bien défini

            $image3 = new Image();
            $image3->setUrl("/images/pizzaorientale.jpg");
            $product3->setImage($image3); // ici $image est bien défini

            // Relation inverse si tu veux :
            // $product->addImage($image);

            $manager->persist($product);
            $manager->persist($product2);
            $manager->persist($product3);
        

        $manager->flush();
    }
}