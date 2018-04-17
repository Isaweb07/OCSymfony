<?php

// src/OC/PlatformBundle/Controller/ApplicationController.php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Form\ApplicationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ApplicationController extends Controller
{
	public function addAppAction($id)
	{
		$application = new Application;
		$em = $this->getDoctrine()->getManager();
		$advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
		$application->setAdvert($advert);
		$request = $this->get('request_stack')->getCurrentRequest();
    	$application->setIp($request->getClientIp());
		$form = $this->createForm(ApplicationType::class, $application);

		// Si la requête est en POST
    	if ($request->isMethod('POST')) {
      	      	$form->handleRequest($request);

      		if ($form->isValid()) {
        		$em = $this->getDoctrine()->getManager();
        		$em->persist($application);
        		$em->flush();

	        	$request->getSession()->getFlashBag()->add('notice', 'Candidature bien enregistrée.');

        		return $this->redirectToRoute('oc_platform_view', array('id' => $id));
      			}
    	
			}

		return $this->render('OCPlatformBundle:Application:addApp.html.twig', array(
      	'form' => $form->createView(),
    	));
	}
}