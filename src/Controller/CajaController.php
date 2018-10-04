<?php

namespace App\Controller;

use App\Entity\Caja;

class CajaController extends AdminController
{
    public function prePersistEntity($entity)
    {
        parent::prePersistEntity($entity);
        $entity->setEmpleadoApertura($this->get('security.token_storage')->getToken()->getUser());
        #$entityManager = $this->getDoctrine()->getManager();
        #$entityManager->persist($entity);
        #$entityManager->flush();
    }
    
}
?>