<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
     * @Route("/news", name="a_news")
     */
    public function a_newsAction()
    {
        return $this->render('AdminBundle::a_news.html.twig');
    }
    
      /**
     * @Route("/users", name="a_users")
     */
    public function a_usersAction()
    {
        return $this->render('AdminBundle::a_users.html.twig');
    }
    
}
