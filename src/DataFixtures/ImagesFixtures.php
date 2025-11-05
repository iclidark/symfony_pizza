<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ImageFixtures extends Fixture
{
    public const IMAGE_REFERENCE = 'Image';
    
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i < 5; $i++) {      
            $image = new Image();
            $image->setUrl(sprintf('images/margharita.jpg', $i));
            $image->setAltText('Une image d\'un pizza margharita! C\'est le n°'. $i . '.');
            $manager->persist($image);
            $this->addReference(self::IMAGE_REFERENCE . '_' . $i, $image);

            $image = new Image();
            $image->setUrl(sprintf('images/3fromage.jpg', $i));
            $image->setAltText('Une image d\'un pizza 3 fromages! C\'est le n°'. $i . '.');
            $manager->persist($image);
            $this->addReference(self::IMAGE_REFERENCE . '_' . $i, $image);

            $image = new Image();
            $image->setUrl(sprintf('images/pizzaorientale.jpg', $i));
            $image->setAltText('Une image d\'un pizza orientale! C\'est le n°'. $i . '.');
            $manager->persist($image);
            $this->addReference(self::IMAGE_REFERENCE . '_' . $i, $image);
        }

        $manager->flush();
    }
}