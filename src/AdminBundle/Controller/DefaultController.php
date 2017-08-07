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
     * @Route("/manage-news", name="manage_news")
     */
    public function manageNewsAction()
    {
        return $this->render('AdminBundle::manage_news.html.twig');
    }
    
      /**
     * @Route("/manage-users", name="manage_users")
     */
    public function manageUsersAction()
    {
        return $this->render('AdminBundle::manage_users.html.twig');
    }
    
}
