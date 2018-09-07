<?php

namespace App\Controller;

use App\Entity\Elemento;

class ElementoController extends AdminController
{
    protected function preUpdateEntity($entity)
    {
        $entity->setUltimaReposicion(new \DateTime());
        $this->addFlash('success','Cantidad actualizada');
    }
}