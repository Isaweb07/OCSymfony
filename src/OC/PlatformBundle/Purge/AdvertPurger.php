<?php
// src/OC/PlatformBundle/Purge/AdvertPurger.php

namespace OC\PlatformBundle\Purge;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Repository\AdvertRepository;

class AdvertPurger
{
  private $em = null;
  private $days;

  public function __construct(\Doctrine\ORM\EntityManager $em)
  {
      $this->em = $em;
  }

  public function PurgeAdvertWhithoutApplication($days)
  {
    $adverts = array();

    // récupération du repository
    $repo_advert = $this->em->getRepository('OCPlatformBundle:Advert') ;

    // récupération des annonces sans application, vieille de plus de {$days} jours
    $oldAdverts = $repo_advert->OldAdvert($days);

    // suppression de ces annonces
    foreach ($oldAdverts as $adv)
    {
      $adverts[]=$adv->getTitle();
      $this->em->remove($adv);
    }

    $this->em->flush();
    // retourne les titres des annonces supprimées
    return $adverts;
  }
}
