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

        $specified_page = $request->get('page');

        if ($specified_page != "" && $this->getUser() && $this->isGranted('IS_AUTHENTICATED_FULLY'))
            return $this->redirectToRoute('homepage');
        else if (!$specified_page && !$this->getUser() && !$this->isGranted('IS_AUTHENTICATED_FULLY'))
            return $this->redirectToRoute('homepage', array('page' => 'login'));

        $news = $em->getRepository('AppBundle:News')->getLatestNewsOrderByPublishedAt();

        return $this->render('AppBundle::homepage.html.twig', array('news' => $news, 'specified_page' => $specified_page));
    }
}
