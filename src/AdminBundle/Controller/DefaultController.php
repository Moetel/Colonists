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
     * @Route("/manage-news", name="manage_news")
     */
    public function manageNewsAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $news = $em->getRepository('AppBundle:News')->getAllNewsDesc();
        
        return $this->render('AdminBundle::manage_news.html.twig', array('news' => $news));
    }
    
    /**
     * @Route("/manage-article/{article_id}", name="manage_article")
     */
    public function manageArticleAction(Request $request, $article_id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('AppBundle:News')->find($article_id);
        if (!$article) {
            return $this->redirectToRoute('manage_news');
        }

        return $this->render('AdminBundle::manage_article.html.twig', array('article' => $article));
    }
    
      /**
     * @Route("/manage-users", name="manage_users")
     */
    public function manageUsersAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->getUsersOrderByAlpha();

        return $this->render('AdminBundle::manage_users.html.twig', array('users' => $users));
    }

    /**
     * @Route("/manage-user/{user_id}", name="manage_user")
     */
    public function manageUserAction(Request $request, $user_id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:User')->find($user_id);
        if (!$user) {
            return $this->redirectToRoute('manage_users');
        }

        return $this->render('AdminBundle::manage_user.html.twig', array('user' => $user));
    } 
    
}
