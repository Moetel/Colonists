<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $news = $em->getRepository('AppBundle:News')->getLatestNewsOrderByPublishedAt();

        return $this->render('AppBundle::homepage.html.twig', array('news' => $news));
    }
}
