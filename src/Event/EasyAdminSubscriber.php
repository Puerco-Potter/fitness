<?php
namespace App\Event;

use App\Entity\PagoCuota;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

use App\Controller\PagoCuotaController as theControlador;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
        $entity = $event->getSubject();
        if ($entity['class'] == PagoCuota::class)
        {
            print 'Acá en teoría debería andar';
        }
        
        //$controlador = new theControlador;
        //return $controlador->redirigir();
    }
}