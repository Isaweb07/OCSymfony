<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadAdvert.php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Advert;

class LoadAdvert implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // Liste des noms de compétences à ajouter
    
    $titles = array('Recherche un développeur full stack', 'Recherche un intégrateur web', 'Recherche notre lead développeur', 'Recherche un super référenceur', 'Recherche un développeur Symfony', 'Recherche un développeur PHP confirmé', 'Recherche un webmaster de génie', 'Recherche un développeur Android', 'Recherche le développeur web de l\'année', 'Recherche un cuisinier du web');
    $authors = array('Alexandre', 'Pierre', 'Stéphanie', 'Josette', 'Camille', 'John', 'Sandrine');
    $contents = array('Le profil que nous recherchons est exceptionnel', 'Nous avons une mission pour vous', 'Notre job de rêve vous fera tourner la tête', 'Si vous recherchez un emploi, lisez ce qui suit', 'Notre startup est en pleine campagne mais à la pointe de la technologie', 'Vous avez toujours rêvé de développer vos talents, alors nous pouvons vous offrir cela', 'Dans notre entreprise vous vous sentirez comme un poisson dans l\eau');
    


    foreach ($titles as $title) {
      // On crée l'annonce
      $advert = new Advert();
      $advert->setTitle($title);
      $advert->setAuthor($authors[mt_rand(0, count($authors)-1)]);
      $advert->setContent($contents[mt_rand(0, count($contents)-1)]);

      // On la persiste
      $manager->persist($advert);
    }

    // On déclenche l'enregistrement de toutes les annonces
    $manager->flush();
  }
}
