<?php

namespace App\Controller;

use App\Entity\ESEmpelado;
use App\Entity\Notificacion;

class ESEmpleadoController extends AdminController
{
    public function persistEntity($entity)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $id = $entity->getEmpleado();
        $tipo = $entity->getTipo();
        $rep = $em->getRepository('App\Entity\ESEmpleado');
        $results = $rep->findBy(array('Empleado' => $id), array('id'=>'DESC'),1,0);

        parent::persistEntity($entity);

        //dump($results);exit;
        if ($results != [])
        {            
            if ($results[0]->getTipo() == $tipo)
            {
                $this->addFlash('warning',sprintf('El empleado no ha entrado/salido correctamente, se generó una notificación'));
                $noti = new Notificacion();
                $noti->setCreacion($entity->getFechaYHora());
                if ($entity->getTipo()=='Entrada')
                {
                    $coso = 'Salida';
                }
                else
                {
                    $coso = 'Entrada';
                }

                $noti->setDescripcion($entity->getTipo().' sin su '.$coso.' de '.(string)$entity->getEmpleado().' a las '.(string) $entity->getFechaYHora()->format('Y-m-d'));

                $em->persist($noti);
                $em->flush();

            }
        }
        #dump($results[0]);exit;

    }
}