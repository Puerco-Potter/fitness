<?php

namespace App\Controller;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
    protected function persistEntity($entity)
    {

        $this->em->persist($entity);
        $this->em->flush();
        
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