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

        $user = $this->getUser();

        $specified_page = $request->get('page');

        if ($specified_page != "" && $user && $this->isGranted('IS_AUTHENTICATED_FULLY'))
            return $this->redirectToRoute('homepage');
        else if (!$specified_page && !$user && !$this->isGranted('IS_AUTHENTICATED_FULLY'))
            return $this->redirectToRoute('homepage', array('page' => 'login'));

        $news = $em->getRepository('AppBundle:News')->getLatestNewsOrderByPublishedAt();

        return $this->render('AppBundle::homepage.html.twig', array('news' => $news, 'specified_page' => $specified_page));
    }

    /**
     * @Route("/friend-list", name="friend_list")
     */
    public function friendListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $friend_list = $user->getFriends();

        return $this->render('AppBundle::friend_list.html.twig', array('friend_list' => $friend_list));
    }
}
