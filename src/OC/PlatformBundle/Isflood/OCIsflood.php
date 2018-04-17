<?php
// src/OC/PlatformBundle/Isflood/OCIsflood.php

namespace OC\PlatformBundle\Isflood;

class OCIsflood
{
  private array $infos = null;
  private $seconds;

  public function __construct()
  {
      $this->infos = $infos;
      $this->seconds = $seconds;
  }

  public function isflood($infos,$seconds)
  {
    // test de pas de données
    if (empty($infos)) return false; // première annonce ou première candidature avec cette ip -> pas un flood
    else {
          //calcul date du jour - $seconds
           $datelimit = new \DateTime('-' . $seconds . 'second');
        foreach($info in $infos)
        {
          if ($info->date<$datelimit) return true;
        }
    }

    return false;
  }
}
