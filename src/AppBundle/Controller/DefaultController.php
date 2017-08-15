<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Instance;
use AppBundle\Entity\User;
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

        /** @var User $user */
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

        /** @var User $user */
        $user = $this->getUser();
        if (!$user)
            return $this->redirectToRoute('homepage');

        $friend_list = $user->getFriends();

        return $this->render('AppBundle::friend_list.html.twig', array('friend_list' => $friend_list));
    }

    /**
     * @Route("/instance", name="instance")
     */
    public function instanceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $this->getUser();
        if (!$user)
            return $this->redirectToRoute('homepage');

        if ($user->getInstance() == null)
            return $this->render('AppBundle::create_instance.html.twig', array('user' => $user));

        return $this->render('AppBundle::instance.html.twig', array('user' => $user, 'instance' => $user->getInstance()));
    }

    /**
     * @Route("/create-instance", name="create_instance")
     */
    public function createInstanceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $this->getUser();
        if (!$user)
            return $this->redirectToRoute('homepage');

        if ($user->getInstance() != null)
            return $this->redirectToRoute('instance');

        /** @var Instance $instance */
        $instance = $em->getRepository('AppBundle:Instance')->getFreeInstance();
        if (!$instance) {
            $instance = new Instance();
            $instance->setIsFull(false);
            $instance->setSize(10);
        }

        $instance->addUser($user);

        if ($instance->getNbUsers() == $instance->getSize())
            $instance->setIsFull(true);

        $em->persist($instance);
        $em->flush();

        return $this->redirectToRoute('instance');
    }
}
