<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ServerController extends Controller
{
    /**
     * @Route("/get-notifications", name="get_notifications")
     */
    public function getNotificationsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        if (!$user && !$this->isGranted('IS_AUTHENTICATED_FULLY'))
            return new JsonResponse(array('success' => false));

        $notifs = $em->getRepository('AppBundle:Notification')->getUnreadForUser($user);

        $unread_notifs = array();
        $i = 0;
        /** @var Notification $notif */
        foreach ($notifs as $notif) {
            $unread_notifs[$i]['message'] = $notif->getMessage();
            $unread_notifs[$i]['url'] = $notif->getUrl();
            $unread_notifs[$i]['date'] = $notif->getCreatedAt()->format('H:i d/m/Y');

            $i++;
        }

        return new JsonResponse(array('success' => true, 'unread_notifs' => $unread_notifs));
    }

}
