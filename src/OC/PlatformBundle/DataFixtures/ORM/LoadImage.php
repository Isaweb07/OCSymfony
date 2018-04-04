<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadImage.php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Image;

class LoadImage implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // Liste des noms de compétences à ajouter
    $urls = array('https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Creative-Tail-Animal-cat.svg/128px-Creative-Tail-Animal-cat.svg.png', 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fc/Creative-Tail-Animal-panda.svg/128px-Creative-Tail-Animal-panda.svg.png', 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d7/Creative-Tail-Animal-shark.svg/128px-Creative-Tail-Animal-shark.svg.png', 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Creative-Tail-Animal-dog.svg/128px-Creative-Tail-Animal-dog.svg.png', 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/Creative-Tail-Animal-turtle.svg/128px-Creative-Tail-Animal-turtle.svg.png', 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/75/Creative-Tail-Animal-elephant.svg/128px-Creative-Tail-Animal-elephant.svg.png');
    $alts = array('chat','panda','requin','chien','tortue','éléphant');
    $index = 0;


    foreach ($i = 1; $i <= 10; $i++) {
      // On crée l'image
      $image = new Image();
      $image->setUrl($url);
      $image->setAlt($alts[$index]);
      $index++;
      if ($index > 5) $index = 0;

      // On la persiste
      $manager->persist($image);
    }

    // On déclenche l'enregistrement de toutes les compétences
    $manager->flush();
  }
}
