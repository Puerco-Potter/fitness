<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use App\Entity\Movimiento;
use App\Entity\Caja;

class MovimientoController extends AdminController
{
    public function prePersistEntity($entity)
    {
        parent::prePersistEntity($entity);
        $em = $this->getDoctrine()->getEntityManager();
        $entity->setEmpleado($this->get('security.token_storage')->getToken()->getUser());
        /*
        $rep = $em->getRepository('App\Entity\Caja');
        $results = $rep->findBy(array('fecha' => 'CURRENT_DATE()', 'cierre' => 'NULL'),array('id'=>'DESC'),1,0);
        dump($results);exit;
        if($results != [])
        {
            $entity->setCaja($results[0]);
        }
        */
        #$entityManager = $this->getDoctrine()->getManager();
        #$entityManager->persist($entity);
        #$entityManager->flush();
    }
    public function persistEntity($entity)
    {
        parent::persistEntity($entity);
        $id = $entity->getCaja()->getId();
        $em = $this->getDoctrine()->getEntityManager();
        $caja = $em->getRepository(Caja::class)->find($id);
        if ($entity->getTipo()=='Ingreso')
        {
            $caja->setSaldoFinal($caja->getSaldoFinal() + $entity->getMonto());

        }
        else
        {
            $caja->setSaldoFinal($caja->getSaldoFinal() - $entity->getMonto());
        }
      
        $em->persist($caja);
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

        $cajas = $this->getDoctrine()
        ->getManager()
        ->createQuery('SELECT c FROM App\Entity\Caja c WHERE c.fecha >= CURRENT_DATE() AND c.cierre IS NULL')
        ->getResult();

        if ($cajas !=[])
        {
            $entity->setCaja($cajas[0]);
        }
        else
        {
            $this->addFlash('error',sprintf('No hay ninguna caja abierta'));
            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'Caja'
            ));
        }
        #dump($entity);exit;
        if ($newForm->isSubmitted() && $newForm->isValid() && $cajas != []) {
            $this->dispatch(EasyAdminEvents::PRE_PERSIST, array('entity' => $entity));

            $this->executeDynamicMethod('prePersist<EntityName>Entity', array($entity));
            $this->executeDynamicMethod('persist<EntityName>Entity', array($entity));

            $this->dispatch(EasyAdminEvents::POST_PERSIST, array('entity' => $entity));

            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'Movimiento'
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
    
    public function anularAction()
    {
        $id = $this->request->query->get('id');
        $entity = $this->em->getRepository(Movimiento::class)->find($id);
        $entity->setAnulado(TRUE);

        $id = $entity->getCaja()->getId();
        $em = $this->getDoctrine()->getEntityManager();
        $caja = $em->getRepository(Caja::class)->find($id);
        if ($entity->getTipo()=='Ingreso')
        {
            $caja->setSaldoFinal($caja->getSaldoFinal() - $entity->getMonto());

        }
        else
        {
            $caja->setSaldoFinal($caja->getSaldoFinal() + $entity->getMonto());
        }
      
        $em->persist($caja);

        $this->em->flush();

        return $this->redirectToRoute('easyadmin', array(
            'action' => 'list',
            'entity' => $this->request->query->get('entity'),
        ));

    }
    
}
?>