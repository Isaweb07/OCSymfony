Activit� : Purger vos entit�s

Modification de l'entit� Advert pour ajouter une liaison bidirectionnelle avec AdvertSkill et permettre la r�cup�ration des enregistrements
advertskill correspondant � une annonce
	Ajout de la variable $advertskills dans l'entit� Advert. Cette variable a un cascade 'remove' pour que Doctrine puisse
	propager la suppression des annonces aux enregistrements advertskill correspondants.

	/**
   	 * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\AdvertSkill", mappedBy="advert", cascade={"remove"})
  	 */
  	private $advertskills; // Notez le � s �, une annonce est li�e � plusieurs comp�tences

Cr�ation d'un service oc_platform.purger.advert d�clar� dans src/OC/PlatformBundle/Resources/config/services.yml
	Ce service fait r�f�rence � la classe OC\PlatformBundle\Purge\AdvertPurger
	et a pour argument le service Doctrine Entity Manager

	Dans la classe AdvertPurger, la fonction PurgeAdvertWhithoutApplication($days) :
	- r�cup�re le repository de Advert,
	- appelle la fonction OldAdvert($days) du repository,
	- supprime les annonces trouv�es
	- et retourne un tableau des titres des annonces supprim�es (pour affichage).

Cr�ation dans le repository d'Advert (src/OC/PlatformBundle/Repository/AdvertRepository.php), d'une fonction OldAdvert($days)
	Cette fonction :
	- calcule la date du jour - $days = datelimite
	- ex�cute une requ�te qui cherche les annonces sans candidature, et les enregistrements advertskill associ�s, dont la date est plus
	ancienne que la datelimite
	- renvoit ce r�sultat

	Les annonces sans candidatures peuvent �tre trouv�es soit par 'a.nbApplications=0', soit par 'a.applications IS EMPTY'

Cr�ation dans le controleur AdvertController (src/OC/PlatformBundle/Controller/AdvertController.php) d'une fonction purgeAction($days)
	Cette fonction instancie le service 'oc_platform.purger.advert' et appelle la fonction PurgeAdvertWhithoutApplication($days).
	Selon le r�sultat retourn� (tableau de titres d'annonces supprim�es), elle positionne les variables $titre, $paragraphe et $listannonces
	qui sont transmises � la vue delete.html.twig.

Cr�ation de la route dans src/OC/PlatformBundle/Resources/config/routing.yml pour appeler la fonction purgeAction($days)
	Cette route (/purge/{days}) a pour argument facultatif {days}
	Cet argument est positionn� � la valeur 10 par d�faut.

Cr�ation de la vue src/OC/PlatformBundle/Resources/views/Advert/delete.html.twig pour afficher :
	- le nombre d'annonces supprim�es (aucune annonce si 0 annonce trouv�e)
	- le cas �ch�ant, les titres des annonces supprim�es

Ajout dans src/OC/CoreBundle/Resources/views/layout.html.twig d'un lien avec appel � 'oc_platform_purge' avec comme argument 'days': 10

Pour tester la fonction de purge, on peut remplir la base de donn�es avec les donn�es contenues dans le fichier 'symfony2.sql'. Penser � 
d�cocher la v�rification des cl�s �trang�res. Les annonces d'id 2,4,8 et 10 sont sans candidature.
	
	