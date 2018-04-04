Activité : Purger vos entités

Modification de l'entité Advert pour ajouter une liaison bidirectionnelle avec AdvertSkill et permettre la récupération des enregistrements
advertskill correspondant à une annonce
	Ajout de la variable $advertskills dans l'entité Advert. Cette variable a un cascade 'remove' pour que Doctrine puisse
	propager la suppression des annonces aux enregistrements advertskill correspondants.

	/**
   	 * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\AdvertSkill", mappedBy="advert", cascade={"remove"})
  	 */
  	private $advertskills; // Notez le « s », une annonce est liée à plusieurs compétences

Création d'un service oc_platform.purger.advert déclaré dans src/OC/PlatformBundle/Resources/config/services.yml
	Ce service fait référence à la classe OC\PlatformBundle\Purge\AdvertPurger
	et a pour argument le service Doctrine Entity Manager

	Dans la classe AdvertPurger, la fonction PurgeAdvertWhithoutApplication($days) :
	- récupère le repository de Advert,
	- appelle la fonction OldAdvert($days) du repository,
	- supprime les annonces trouvées
	- et retourne un tableau des titres des annonces supprimées (pour affichage).

Création dans le repository d'Advert (src/OC/PlatformBundle/Repository/AdvertRepository.php), d'une fonction OldAdvert($days)
	Cette fonction :
	- calcule la date du jour - $days = datelimite
	- exécute une requête qui cherche les annonces sans candidature, et les enregistrements advertskill associés, dont la date est plus
	ancienne que la datelimite
	- renvoit ce résultat

	Les annonces sans candidatures peuvent être trouvées soit par 'a.nbApplications=0', soit par 'a.applications IS EMPTY'

Création dans le controleur AdvertController (src/OC/PlatformBundle/Controller/AdvertController.php) d'une fonction purgeAction($days)
	Cette fonction instancie le service 'oc_platform.purger.advert' et appelle la fonction PurgeAdvertWhithoutApplication($days).
	Selon le résultat retourné (tableau de titres d'annonces supprimées), elle positionne les variables $titre, $paragraphe et $listannonces
	qui sont transmises à la vue delete.html.twig.

Création de la route dans src/OC/PlatformBundle/Resources/config/routing.yml pour appeler la fonction purgeAction($days)
	Cette route (/purge/{days}) a pour argument facultatif {days}
	Cet argument est positionné à la valeur 10 par défaut.

Création de la vue src/OC/PlatformBundle/Resources/views/Advert/delete.html.twig pour afficher :
	- le nombre d'annonces supprimées (aucune annonce si 0 annonce trouvée)
	- le cas échéant, les titres des annonces supprimées

Ajout dans src/OC/CoreBundle/Resources/views/layout.html.twig d'un lien avec appel à 'oc_platform_purge' avec comme argument 'days': 10

Pour tester la fonction de purge, on peut remplir la base de données avec les données contenues dans le fichier 'symfony2.sql'. Penser à 
décocher la vérification des clés étrangères. Les annonces d'id 2,4,8 et 10 sont sans candidature.
	
	