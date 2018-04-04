<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadAdvert.php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Application;

class LoadApplication implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // Liste des noms de compétences à ajouter
    
    $authors = array('Charles', 'Elise', 'Marine', 'Thomas', 'Bertrand', 'Laurent', 'Léa');
    $contents = array('Je suis la personne qu\'il vous faut', 'J\ai toutes les compétences', 'J\'adore ce que vous faites', 'Ne cherchez plus je suis la personne que vous souhaitez', 'Je suis fan des technos que vous utilisez', 'J\ai toujours voulu travailler chez vous', 'Je suis super motivé');
    

    for ($i = 1; $i <= 10; $i++) {
      // On crée la candidature
      $application = new Application();
      $application->setAuthor($authors[mt_rand(0, count($authors)-1)]);
 	  $application->setContent($contents[mt_rand(0, count($contents)-1)]);

      // On la persiste
      $manager->persist($application);
    }

    // On déclenche l'enregistrement de toutes les annonces
    $manager->flush();
  }
}
