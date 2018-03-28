<?php

namespace IB\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdvertController extends Controller
{
    public function indexAction()
    {
    	// Notre liste d'annonce en dur
        $listAdverts = array(
         array(
            'title'   => 'Recherche développpeur PHP',
            'id'      => 1,
            'author'  => 'Jacques',
            'content' => 'Nous recherchons un développeur PHP expérimenté sur Tours. Blabla…',
            'date'    => new \Datetime()),
        array(
            'title'   => 'Mission de webmaster e-commerce',
            'id'      => 2,
            'author'  => 'Léa',
            'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet e-commerce. Blabla…',
            'date'    => new \Datetime()),
        array(
            'title'   => 'Offre de stage webdesigner HTML5/CSS3',
            'id'      => 3,
            'author'  => 'Sandrine',
            'content' => 'Nous proposons un stage de 6 mois pour webdesigner. Il s\'agit de mettre en oeuvre les design sur notre site internet. Blabla…',
            'date'    => new \Datetime())
        );


        return $this->render('IBCoreBundle:Advert:index.html.twig', array(
        'listAdverts' => $listAdverts
        ));
    }

    public function contactAction(Request $request)
 	{
   		$session = $request->getSession();

   		// On met un message flash
    	$session->getFlashBag()->add('info', 'Nous sommes désolés mais la page de contact n’est pas encore disponible.Revenez bientôt !');

    	// Puis on redirige vers la page d'accueil
    	return $this->redirectToRoute('ib_core_homepage');
  	}

    public function viewAction($id)
  	{
        $advert = array(
        'title'   => 'Recherche développpeur PHP',
        'id'      => $id,
        'author'  => 'Alexandre',
        'content' => 'Nous recherchons un développeur PHP expérimenté sur Tours. Blabla…',
        'date'    => new \Datetime()
        );

        return $this->render('IBCoreBundle:Advert:view.html.twig', array(
        'advert' => $advert
        ));
  	}

}
