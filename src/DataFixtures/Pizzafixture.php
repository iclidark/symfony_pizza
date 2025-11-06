<?php

namespace App\DataFixtures;

use App\Entity\Pizza;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Pizzafixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $pizzas = [
            ['name' => 'Pizza 3 fromages', 'description' => 'Une délicieuse pizza avec du fromage de chèvre, de l\'emmental et du parmesan.'],
            ['name' => 'Pizza orientale', 'description' => 'Une pizza savoureuse avec du merguez, des poivrons et des oignons.'],
            ['name' => 'Pizza margherita', 'description' => 'La pizza classique avec de la sauce tomate, de la mozzarella et du basilic frais.'],
        ];

        foreach ($pizzas as $pizzaData) {
            $pizza = new Pizza();
            $pizza->setName($pizzaData['name']);
            $pizza->setDescription($pizzaData['description']);
            $manager->persist($pizza);
        }

        $manager->flush();
    }
}
