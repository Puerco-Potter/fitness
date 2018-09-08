<?php

namespace App\Controller;

use App\Entity\Alumno;

class AlumnoController extends AdminController
{

    protected function persistEntity($entity)
    {
        parent::persistEntity($entity);
        
        #$id = $this->request->query->get('id');
        

        #var_dump($entity);
        #sleep(60);
        #$entity = $this->em->getRepository('App:Alumno')->find($id);

        #$this->addFlash('success',sprintf('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA: '.$entity->__toString()));
        /*
        return $this->redirectToRoute('easyadmin', [
            'action' => 'show',
            'entity' => $this->request->query->get('entity'),
            'id' => $id,
                    ]);
        */
    }
}