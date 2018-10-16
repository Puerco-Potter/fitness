<?php

namespace App\Controller;

use App\Entity\Movimiento;
use App\Entity\Caja;

class MovimientoController extends AdminController
{
    public function prePersistEntity($entity)
    {
        parent::prePersistEntity($entity);
        $entity->setEmpleado($this->get('security.token_storage')->getToken()->getUser());
        #$entityManager = $this->getDoctrine()->getManager();
        #$entityManager->persist($entity);
        #$entityManager->flush();
    }
    public function persistEntity($entity)
    {
        parent::persistEntity($entity);
        $id = $entity->getCaja()->getId();
        $em = $this->getDoctrine()->getEntityManager();
        $caja = $em->getRepository(Caja::class)->find($id);
        if ($entity->getTipo()=='Ingreso')
        {
            $caja->setSaldoFinal($caja->getSaldoFinal() + $entity->getMonto());

        }
        else
        {
            $caja->setSaldoFinal($caja->getSaldoFinal() - $entity->getMonto());
        }
      
        $em->persist($caja);
        $em->flush();

    }
    
    public function anularAction()
    {
        $id = $this->request->query->get('id');
        $entity = $this->em->getRepository(Movimiento::class)->find($id);
        $entity->setAnulado(TRUE);

        $id = $entity->getCaja()->getId();
        $em = $this->getDoctrine()->getEntityManager();
        $caja = $em->getRepository(Caja::class)->find($id);
        if ($entity->getTipo()=='Ingreso')
        {
            $caja->setSaldoFinal($caja->getSaldoFinal() - $entity->getMonto());

        }
        else
        {
            $caja->setSaldoFinal($caja->getSaldoFinal() + $entity->getMonto());
        }
      
        $em->persist($caja);

        $this->em->flush();

        return $this->redirectToRoute('easyadmin', array(
            'action' => 'list',
            'entity' => $this->request->query->get('entity'),
        ));

    }
    
}
?>