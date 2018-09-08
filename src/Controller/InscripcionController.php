<?php

namespace App\Controller;

use App\Entity\Inscripcion;
use App\Entity\Alumno;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InscripcionController extends AdminController
{
    public function persistEntity($entity)
    {
        parent::persistEntity($entity);
        $id = $entity->getAlumno()->getId();
        $monto = $entity->getCuota();

        $em = $this->getDoctrine()->getEntityManager();

        $qb = $this->em->createQueryBuilder();
        $qb->update('App\Entity\Alumno','a')
            ->set('a.balance','a.balance - '.(string)$monto)
            ->where('a.id = '.(string)$id);
        return $qb->getQuery()->getResult();
    }
}