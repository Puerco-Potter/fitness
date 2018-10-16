<?php

namespace App\Controller;

use App\Entity\Movimiento;

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
    
    public function anularAction()
    {
        $id = $this->request->query->get('id');
        $entity = $this->em->getRepository(Movimiento::class)->find($id);
        $entity->setAnulado(TRUE);
        $this->em->flush();

        return $this->redirectToRoute('easyadmin', array(
            'action' => 'list',
            'entity' => $this->request->query->get('entity'),
        ));

    }
    
}
?>