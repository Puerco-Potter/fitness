<?php

namespace App\Controller;

use App\Entity\Combo;
use App\Entity\Alumno;
use App\Entity\Inscripcion;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;

class ComboController extends AdminController
{
    public function persistEntity($entity)
    {
        parent::persistEntity($entity);
        $id = $entity->getAlumno()->getId();
        $monto = $entity->getMonto();

        $em = $this->getDoctrine()->getEntityManager();

        $alumno = $em->getRepository(Alumno::class)->find($id);
        $alumno->setBalance($alumno->getBalance() - $entity->getMonto());
        $em->persist($alumno);

        $entity->setSaldo(-$monto);
        $em->persist($entity);
        $em->flush();
    }

    /**
     * The method that is executed when the user performs a 'new' action on an entity.
     *
     * @return Response|RedirectResponse
     */
    public function newAction()
    {
        
        $this->dispatch(EasyAdminEvents::PRE_NEW);

        $entity = $this->executeDynamicMethod('createNew<EntityName>Entity');

        

        $easyadmin = $this->request->attributes->get('easyadmin');
        $easyadmin['item'] = $entity;
        $this->request->attributes->set('easyadmin', $easyadmin);

        $fields = $this->entity['new']['fields'];

        $newForm = $this->executeDynamicMethod('create<EntityName>NewForm', array($entity, $fields));

        $newForm->handleRequest($this->request);

        if ($newForm->isSubmitted() && $newForm->isValid())
        {
            $this->dispatch(EasyAdminEvents::PRE_PERSIST, array('entity' => $entity));
            
            foreach ($entity->getInscripciones() as &$x)
            {
                $x->setAlumno($entity->getAlumno());
            }
            #dump($entity);exit;
            $this->executeDynamicMethod('prePersist<EntityName>Entity', array($entity));
            $this->executeDynamicMethod('persist<EntityName>Entity', array($entity));

            $this->dispatch(EasyAdminEvents::POST_PERSIST, array('entity' => $entity));

            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'Combo'
            ));
        }

        $this->dispatch(EasyAdminEvents::POST_NEW, array(
            'entity_fields' => $fields,
            'form' => $newForm,
            'entity' => $entity,
        ));

        $parameters = array(
            'form' => $newForm->createView(),
            'entity_fields' => $fields,
            'entity' => $entity,
        );

        return $this->executeDynamicMethod('render<EntityName>Template', array('new', $this->entity['templates']['new'], $parameters));
    
    }
}