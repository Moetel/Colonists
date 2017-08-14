<?php

namespace AppBundle\Services;


use AppBundle\Entity\Notification;
use Doctrine\ORM\EntityManager;

class NotificationManager
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function createNotification($type_notif, $to_user, $url = null)
    {
        //TODO: new Notification;
        if (!$type_notif)
            return null;
        if (!$to_user)
            return null;

        $notif = new Notification();
        $notif->setType($type_notif);
        $notif->setUser($to_user);
        $notif->setUrl($url);
        $notif->setIsRead(false);

        $this->em->persist($notif);
        $this->em->flush();

        return $notif;
    }
}