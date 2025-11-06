<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ImagesFixtures extends Fixture
{
    public const IMAGE_REFERENCE = 'Image';
    
    public function load(ObjectManager $manager): void
    {
        $refCounter = 1;
        for($i = 1; $i < 5; $i++) {      
            $image = new Image();
            $image->setUrl('images/margharita.jpg');
            $image->setAltText('Une image d\'un pizza margharita! C\'est le n°'. $i . '.');
            $manager->persist($image);
            $this->addReference(self::IMAGE_REFERENCE . '_' . $refCounter++, $image);

            $image = new Image();
            $image->setUrl('images/3fromage.jpg');
            $image->setAltText('Une image d\'un pizza 3 fromages! C\'est le n°'. $i . '.');
            $manager->persist($image);
            $this->addReference(self::IMAGE_REFERENCE . '_' . $refCounter++, $image);

            $image = new Image();
            $image->setUrl('images/pizzaorientale.jpg');
            $image->setAltText('Une image d\'un pizza orientale! C\'est le n°'. $i . '.');
            $manager->persist($image);
            $this->addReference(self::IMAGE_REFERENCE . '_' . $refCounter++, $image);
        }

        $manager->flush();
    }
}