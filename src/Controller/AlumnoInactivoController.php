<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\Entity\AlumnoInactivo;

class AlumnoInactivoController extends AdminController
{


    public function activarAction()
    {
        $id = $this->request->query->get('id');
        $entity = $this->em->getRepository(Alumno::class)->find($id);
        $entity->setInactivo(FALSE);
        $this->em->flush();

        return $this->redirectToRoute('easyadmin', array(
            'action' => 'list',
            'entity' => $this->request->query->get('entity'),
        ));

    }
}