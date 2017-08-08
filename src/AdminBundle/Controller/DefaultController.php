<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\News;
use AppBundle\Form\NewsType;
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
     * @Route("/create-news", name="create_news")
     */
    public function createNewsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $news = new News();

        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($news);
                $em->flush();

                return $this->redirectToRoute('list_news');
            }
        }

        return $this->render('AdminBundle::create_news.html.twig', array('form' => $form->createView()));
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

        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($news);
                $em->flush();

                return $this->redirectToRoute('list_news');
            }
        }

        return $this->render('AdminBundle::edit_news.html.twig', array('form' => $form->createView()));
    }
    /**
     * @Route("/remove-news/{news_id}", name="remove_news")
     */
    public function removeNewsAction(Request $request, $news_id)
    {
        $em = $this->getDoctrine()->getManager();

        $news = $em->getRepository('AppBundle:News')->find($news_id);
        if (!$news) {
            return $this->redirectToRoute('list_news');
        }

        $em->remove($news);
        $em->flush();

        return $this->redirectToRoute('list_news');
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
