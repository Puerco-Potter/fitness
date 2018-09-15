<?php

namespace App\Controller;

use App\Entity\Alumno;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as coso;

class AlumnoController extends AdminController
{

    protected function persistEntity($entity)
    {
        parent::persistEntity($entity);
        
        //$id = $this->request->query->get('id');
        

        #var_dump($entity);
        #sleep(60);
        //$entity = $this->em->getRepository('App:Alumno')->find($id);

        #$this->addFlash('success',sprintf('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA: '.$entity->__toString()));
        //sleep(60);
        /*
        dump($this->redirectToRoute('easyadmin', ['entity' => 'Actividad', 'action' => 'list']));exit;
        return $this->redirectToRoute('easyadmin', ['entity' => 'Actividad', 'action' => 'list']);
        */
        
    }
}