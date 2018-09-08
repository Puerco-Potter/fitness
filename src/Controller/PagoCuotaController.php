<?php

namespace App\Controller;

use App\Entity\PagoCuota;
use App\Entity\Alumno;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PagoCuotaController extends AdminController
{
    public function __construct()
    {
        //parent::__construct();
        //print '_PagoCuotaController se creó_';
    }

    public function persistEntity($entity)
    {
        parent::persistEntity($entity);
        $id = $entity->getInscripcion()->getAlumno()->getId();
        $monto = $entity->getMonto();

        $em = $this->getDoctrine()->getEntityManager();

        $qb = $this->em->createQueryBuilder();
        $qb->update('App\Entity\Alumno','a')
            ->set('a.balance','a.balance + '.(string)$monto)
            ->where('a.id = '.(string)$id);
        return $qb->getQuery()->getResult();


    }
}
?>