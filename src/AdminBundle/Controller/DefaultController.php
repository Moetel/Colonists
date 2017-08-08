<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="admin_homepage")
     */
    public function indexAction()
    {
        return $this->render('AdminBundle::index.html.twig');
    }
    
    /**
     * @Route("/list-news", name="list_news")
     */
    public function listNewsAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $news = $em->getRepository('AppBundle:News')->getNewsOrderByCreatedAt();
        
        return $this->render('AdminBundle::list_news.html.twig', array('news' => $news));
    }
    
    /**
     * @Route("/edit-news/{news_id}", name="edit_news")
     */
    public function editNewsAction(Request $request, $news_id)
    {
        $em = $this->getDoctrine()->getManager();

        $news = $em->getRepository('AppBundle:News')->find($news_id);
        if (!$news) {
            return $this->redirectToRoute('list_news');
        }

        return $this->render('AdminBundle::edit_news.html.twig', array('news' => $news));
    }
    
      /**
     * @Route("/list-users", name="list_users")
     */
    public function listUsersAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->getUsersOrderByAlpha();

        return $this->render('AdminBundle::list_users.html.twig', array('users' => $users));
    }

    /**
     * @Route("/edit-user/{user_id}", name="edit_user")
     */
    public function editUserAction(Request $request, $user_id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')->find($user_id);
        if (!$user) {
            return $this->redirectToRoute('list_users');
        }

        return $this->render('AdminBundle::edit_user.html.twig', array('user' => $user));
    } 
    
}
