<?php
namespace App\Event;

use App\Entity\PagoCuota;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

use App\Controller\PagoCuotaController as pepe;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as deController;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::PRE_SHOW => 'onPreShow',
        ];
    }

    public function onPreShow(GenericEvent $event)
    {
        //dump($event);die;
        #$entity = $event->getSubject();
        #if ($entity['class'] == PagoCuota::class)
        #{
        #   return pepe::redirigir('login');
        #}
        
        //$controlador = new theControlador;
        //return $controlador->redirigir();
    }
}