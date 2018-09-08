<?php

namespace App\Controller;

use App\Entity\RegistroMantenimiento;
use App\Entity\Equipamiento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegistroMantenimientoController extends AdminController
{
    public function __construct()
    {
        //parent::__construct();
        //print '_PagoCuotaController se creó_';
    }

    public function persistEntity($entity)
    {
        parent::persistEntity($entity);
        $id = $entity->getEquipamiento()->getId();
        $fecha = $entity->getFecha();
        $fecha = (string)$fecha->format("Ymd");

        $em = $this->getDoctrine()->getEntityManager();

        $qb = $this->em->createQueryBuilder();
        $qb->update('App\Entity\Equipamiento','e')
            ->set('e.ultimoMantenimiento',$fecha)
            ->where('e.id = '.(string)$id);
        return $qb->getQuery()->getResult();


    }
}