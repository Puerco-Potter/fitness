<?php

namespace App\Controller;

use App\Entity\PagoCuota;
use App\Entity\Alumno;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PagoCuotaController extends AdminController
{
    public function persistEntity($entity)
    {
        parent::persistEntity($entity);
        $id = $entity->getInscripcion()->getAlumno()->getId();
        $monto = $entity->getMonto();
		$cajero = $this->get('security.token_storage')->getToken()->getUser()->getUsername();
		
        $em = $this->getDoctrine()->getEntityManager();

        $qb = $this->em->createQueryBuilder();
        $qb->update('App\Entity\Alumno','a')
            ->set('a.balance','a.balance + '.(string)$monto)
            ->where('a.id = '.(string)$id);
        
		$qqb = $this->em->createQueryBuilder();
		$qqb->update('App\Entity\PagoCuota','p')
            ->set('p.cajero', "'".(string)$cajero."'")
            ->where('p.id = '.$entity->getId());
        return $qqb->getQuery()->getResult();


    }
}