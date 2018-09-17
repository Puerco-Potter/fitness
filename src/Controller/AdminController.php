<?php

namespace App\Controller;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
    
    protected function removeEntity($entity)
    {
        parent::removeEntity($entity);
        $this->addFlash('warning',sprintf('Se ha eliminado correctamente'));
    }

    protected function updateEntity($entity)
    {
        parent::updateEntity($entity);
        $this->addFlash('success',sprintf('Se ha actualizado: '.$entity->__toString()));
    }

    protected function persistEntity($entity)
    {
        parent::persistEntity($entity);
        
        #$id = $this->request->query->get('id');
        #$entity = $this->em->getRepository('App:Alumno')->find($id);

        $this->addFlash('success',sprintf('Se ha registrado en el sistema: '.$entity->__toString()));
        /*
        return $this->redirectToRoute('easyadmin', [
            'action' => 'show',
            'entity' => $this->request->query->get('entity'),
            'id' => $id,
        ]);
        */
    }
}