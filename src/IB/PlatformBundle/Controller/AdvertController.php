<?php

namespace IB\PlatformBundle\Controller;

use IB\PlatformBundle\Entity\Advert;
use IB\PlatformBundle\Entity\Application;
use IB\PlatformBundle\Entity\Skill;
use IB\PlatformBundle\Entity\AdvertSkill;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use IB\PlatformBundle\Entity\Image;

class AdvertController extends Controller
{
    public function indexAction($page,$nbperpage)
    {
        // On ne sait pas combien de pages il y a
        // Mais on sait qu'une page doit être supérieure ou égale à 1
        if ($page < 1) {
        // On déclenche une exception NotFoundHttpException, cela va afficher
        // une page d'erreur 404 (qu'on pourra personnaliser plus tard d'ailleurs)
            throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
            }

        // Ici, on récupérera la liste des annonces, puis on la passera au template

        $listAdverts = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('IBPlatformBundle:Advert')
          ->getAdverts($page,$nbperpage);

        // On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
         $nbPages = ceil(count($listAdverts) / $nbperpage);

      // Si la page n'existe pas, on retourne une 404
       if ($page > $nbPages) {
        throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        // Mais pour l'instant, on ne fait qu'appeler le template
        return $this->render('IBPlatformBundle:Advert:index.html.twig', array(
        'listAdverts' => $listAdverts,
        'page' => $page,
        'nbPerPage' => $nbperpage
        ));
    }

    public function menuAction($limit)
    {
        $em = $this->getDoctrine()->getManager();
          
        $listAdverts = $em->getRepository('IBPlatformBundle:Advert')->findBy(
          array(),                 // Pas de critère
          array('date' => 'desc'), // On trie par date décroissante
          $limit,                  // On sélectionne $limit annonces
          0                        // À partir du premier
          );

        // On récupère la liste des catégories
        $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('IBPlatformBundle:Category')  ;
        $listCategories = $repository->findAll();

        return $this->render('IBPlatformBundle:Advert:menu.html.twig', array(
        // Tout l'intérêt est ici : le contrôleur passe
        // les variables nécessaires au template !
        'listAdverts' => $listAdverts,
        'listCategories' => $listCategories
        ));
  }


    public function byeAction($id)
    {
        $content = $this
        	->get('templating')
        	->render('IBPlatformBundle:Advert:bye.html.twig', array('nom'=>'Toto'));
    	return new Response($content);
    }

  public function viewAction($id)
  {
      $em = $this->getDoctrine()->getManager();

      // On récupère l'annonce $id
      $advert = $em->getRepository('IBPlatformBundle:Advert')->find($id);

      if (null === $advert) {
          throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
          }

      // On récupère la liste des candidatures de cette annonce
      $listApplications = $em
          ->getRepository('IBPlatformBundle:Application')
          ->findBy(array('advert' => $advert));

      // On récupère maintenant la liste des AdvertSkill
      $listAdvertSkills = $em
          ->getRepository('IBPlatformBundle:AdvertSkill')
          ->findBy(array('advert' => $advert));


      return $this->render('IBPlatformBundle:Advert:view.html.twig', array(
          'advert'           => $advert,
          'listApplications' => $listApplications,
          'listAdvertSkills' => $listAdvertSkills
          ));

  }
    

  public function addAction(Request $request)
  {
     // Création de l'entité
      $advert = new Advert();
      $advert->setTitle('Recherche développeur PHP.');
      $advert->setAuthor('Alexandre');
      $advert->setContent("Nous recherchons un développeur PHP sur Septème. Blabla…");
      // On peut ne pas définir ni la date ni la publication,
      // car ces attributs sont définis automatiquement dans le constructeur

      // Création de l'entité Image
      $image = new Image();
      $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
      $image->setAlt('Job de rêve');

      // On lie l'image à l'annonce
      $advert->setImage($image);

      // Création d'une première candidature
      $application1 = new Application();
      $application1->setAuthor('Elise');
      $application1->setContent("J'ai toutes les compétences requises.");

      // Création d'une deuxième candidature par exemple
      $application2 = new Application();
      $application2->setAuthor('Matt');
      $application2->setContent("J'adore le PHP'.");

      // On lie les candidatures à l'annonce
      $application1->setAdvert($advert);
      $application2->setAdvert($advert);


      // On récupère l'EntityManager
      $em = $this->getDoctrine()->getManager();

      // Étape 1 : On « persiste » l'entité
      //$em->persist($advert);

      // Étape 1 ter : pour cette relation pas de cascade lorsqu'on persiste Advert, car la relation est
      // définie dans l'entité Application et non Advert. On doit donc tout persister à la main ici.
      $em->persist($application1);
      $em->persist($application2);

      // Étape 2 : On « flush » tout ce qui a été persisté avant
      //$em->flush();

      // On récupère toutes les compétences possibles
      $listSkills = $em->getRepository('IBPlatformBundle:Skill')->findAll();

      // Pour chaque compétence
      foreach ($listSkills as $skill) {
          // On crée une nouvelle « relation entre 1 annonce et 1 compétence »
          $advertSkill = new AdvertSkill();

          // On la lie à l'annonce, qui est ici toujours la même
          $advertSkill->setAdvert($advert);
          // On la lie à la compétence, qui change ici dans la boucle foreach
          $advertSkill->setSkill($skill);

          // Arbitrairement, on dit que chaque compétence est requise au niveau 'Expert'
          $advertSkill->setLevel('Expert');

          // Et bien sûr, on persiste cette entité de relation, propriétaire des deux autres relations
        $em->persist($advertSkill);
      }

        // Doctrine ne connait pas encore l'entité $advert. Si vous n'avez pas défini la relation AdvertSkill
        // avec un cascade persist (ce qui est le cas si vous avez utilisé mon code), alors on doit persister $advert
        $em->persist($advert);

        // On déclenche l'enregistrement
        $em->flush();

      // Reste de la méthode qu'on avait déjà écrit
      if ($request->isMethod('POST')) {
        $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

        // Puis on redirige vers la page de visualisation de cettte annonce
        return $this->redirectToRoute('ib_platform_view', array('id' => $advert->getId()));
        }

    // Si on n'est pas en POST, alors on affiche le formulaire
    return $this->render('IBPlatformBundle:Advert:add.html.twig', array('advert' => $advert));

  }


  public function editAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $advert = $em->getRepository('IBPlatformBundle:Advert')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
      }

    // La méthode findAll retourne toutes les catégories de la base de données
    $listCategories = $em->getRepository('IBPlatformBundle:Category')->findAll();

    $advert->setAuthor("John");

    // On boucle sur les catégories pour les lier à l'annonce
    foreach ($listCategories as $category) {
        //$advert->addCategory($category);
        }


      // Création d'une première candidature
      $application1 = new Application();
      $application1->setAuthor('Carl');
      $application1->setContent("Ce poste est pour moi.");

      // Création d'une deuxième candidature par exemple
      $application2 = new Application();
      $application2->setAuthor('Sandrine');
      $application2->setContent("Je suis fan de votre startup.");

      // On lie les candidatures à l'annonce
      $application1->setAdvert($advert);
      $application2->setAdvert($advert);

      // Étape 1 ter : pour cette relation pas de cascade lorsqu'on persiste Advert, car la relation est
      // définie dans l'entité Application et non Advert. On doit donc tout persister à la main ici.
      $em->persist($application1);
      $em->persist($application2);
    // Pour persister le changement dans la relation, il faut persister l'entité propriétaire
    // Ici, Advert est le propriétaire, donc inutile de la persister car on l'a récupérée depuis Doctrine

    // Étape 2 : On déclenche l'enregistrement
    $em->flush();


    // Même mécanisme que pour l'ajout
    if ($request->isMethod('POST')) {
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

      return $this->redirectToRoute('ib_platform_view', array('id' => 5));
    }

    return $this->render('IBPlatformBundle:Advert:edit.html.twig', array(
      'advert' => $advert
    ));
  }

  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $advert = $em->getRepository('IBPlatformBundle:Advert')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
      }

    // On boucle sur les catégories de l'annonce pour les supprimer
    foreach ($advert->getCategories() as $category) {
      $advert->removeCategory($category);
      }

    // Pour persister le changement dans la relation, il faut persister l'entité propriétaire
    // Ici, Advert est le propriétaire, donc inutile de la persister car on l'a récupérée depuis Doctrine

    // On déclenche la modification
    $em->flush();

    return $this->render('IBPlatformBundle:Advert:delete.html.twig');
  }

  public function advertByCategoriesAction()
  {
    $listcategories = array('Développeur', 'Graphisme');
    $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('IBPlatformBundle:Advert')  ;
    $listadvert = $repository->getAdvertWithCategories($listcategories);

    return $this->render('IBPlatformBundle:Advert:listByCategory.html.twig',array(
      'listcategories' => $listcategories,
      'listadvert' => $listadvert
    ));
  }

  public function lastApplicationAndAdvertAction($limit)
  {
    // Initialisation de $limit
    if (is_null($limit))
      { $limit=3; }

     $repository = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('IBPlatformBundle:Application')  ;
    $listapplicationsadvert = $repository->getApplicationsWithAdvert($limit);

    return $this->render('IBPlatformBundle:Advert:lastApplicationAndAdvert.html.twig',array(
      'listapplicationsadvert' => $listapplicationsadvert,
      'limit' => $limit
    ));
  }

  public function testAction()
  {
  $advert = new Advert();
  $advert->setTitle("Recherche développeur PHP !");
  $advert->setAuthor("Liliane");
  $advert->setContent("Je voudrais quelqu'un pour développer une application web qui compte les moutons.");

  $em = $this->getDoctrine()->getManager();
  $em->persist($advert);
  $em->flush(); // C'est à ce moment qu'est généré le slug

  return new Response('Slug généré : '.$advert->getSlug());
  // Affiche « Slug généré : recherche-developpeur »
  }
}
