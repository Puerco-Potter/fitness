<?php

namespace App\Controller;

use App\Entity\Caja;
use App\Entity\Movimiento;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\TableChart;

class CajaController extends AdminController
{
    public function cerrarAction()
    {
        $this->dispatch(EasyAdminEvents::PRE_EDIT);

        $id = $this->request->query->get('id');
        $easyadmin = $this->request->attributes->get('easyadmin');
        $entity = $easyadmin['item'];

        if ($this->request->isXmlHttpRequest() && $property = $this->request->query->get('property')) {
            $newValue = 'true' === mb_strtolower($this->request->query->get('newValue'));
            $fieldsMetadata = $this->entity['list']['fields'];

            if (!isset($fieldsMetadata[$property]) || 'toggle' !== $fieldsMetadata[$property]['dataType']) {
                throw new \RuntimeException(sprintf('The type of the "%s" property is not "toggle".', $property));
            }

            $this->updateEntityProperty($entity, $property, $newValue);

            // cast to integer instead of string to avoid sending empty responses for 'false'
            return new Response((int) $newValue);
        }

        $fields = $this->entity['edit']['fields'];

        $editForm = $this->executeDynamicMethod('create<EntityName>EditForm', array($entity, $fields));
        $deleteForm = $this->createDeleteForm($this->entity['name'], $id);

        $editForm->handleRequest($this->request);

        if($entity->getCierre()<$entity->getApertura() AND $entity->getCierre()!= NULL)
        {
            $this->addFlash('error',sprintf('El horario de apertura debe ser menor al de cierre!'));
            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'Caja'
            ));
        }

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->dispatch(EasyAdminEvents::PRE_UPDATE, array('entity' => $entity));

            $this->executeDynamicMethod('preUpdate<EntityName>Entity', array($entity));
            $this->executeDynamicMethod('update<EntityName>Entity', array($entity));

            $this->dispatch(EasyAdminEvents::POST_UPDATE, array('entity' => $entity));

            return $this->redirectToReferrer();
        }

        $this->dispatch(EasyAdminEvents::POST_EDIT);

        $parameters = array(
            'form' => $editForm->createView(),
            'entity_fields' => $fields,
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );

        return $this->executeDynamicMethod('render<EntityName>Template', array('edit', $this->entity['templates']['edit'], $parameters));
    
        $id = $this->request->query->get('id');
        $entity = $this->em->getRepository(Caja::class)->find($id);
        $entity->setCierre(new \DateTime());
        $entity->setEmpleadoCierre($this->get('security.token_storage')->getToken()->getUser());
      
        $em->persist($caja);

        $this->em->flush();

        $this->addFlash('warning',sprintf('Caja cerrada'));

        return $this->redirectToRoute('easyadmin', array(
            'action' => 'list',
            'entity' => 'Caja',
        ));

    }
    public function balanceAction()
    {
        $id = $this->request->query->get('id');
        $em = $this->getDoctrine()->getEntityManager();
        $caja = $em->getRepository(Caja::class)->find($id);
        $movimientos = $em->getRepository(Movimiento::class)->findBy(array('Caja' => $caja->getId()));
        
        $lista = array();
        $elemento = array();
        $elemento = [
            ['label' => 'Horario', 'type' => 'string'],
            ['label' => 'Tipo', 'type' => 'string'],
            ['label' => 'Concepto', 'type' => 'string'],
            ['label' => 'Observaciones', 'type' => 'string'],
            ['label' => 'Monto', 'type' => 'number'],
            ['label' => 'Válido', 'type' => 'boolean']
        ];
        array_push($lista, $elemento);
        foreach ($movimientos as $movimiento)
        {
            $elemento = array();
            array_push($elemento, (string) $movimiento->getHora()->format('H:i:s'));
            array_push($elemento, $movimiento->getTipo());
            array_push($elemento, $movimiento->getConcepto());
            array_push($elemento, $movimiento->getObservaciones());
            array_push($elemento, ['v' => $movimiento->getMonto(), 'f' => '$'.(string)$movimiento->getMonto()]);
            array_push($elemento, $movimiento->getValido());
            array_push($lista,$elemento);
        }        
        $chart = new TableChart();
        $chart->getData()->setArrayToDataTable($lista);
        $chart->getOptions()->setHeight('50%');
        $chart->getOptions()->setWidth('50%');
        return $this->render('bar.html.twig', array('chart' => $chart));
    }

    public function updateEntity($entity)
    {
        $abuelo = get_parent_class(get_parent_class($this));
        $abuelo::updateEntity($entity);
        $this->addFlash('success',sprintf('Se ha cerrado la caja de hoy: '.$entity->__toString()));
    }
    public function prePersistEntity($entity)
    {
        parent::prePersistEntity($entity);
        $entity->setEmpleadoApertura($this->get('security.token_storage')->getToken()->getUser());
    
        #$entityManager = $this->getDoctrine()->getManager();
        #$entityManager->persist($entity);
        #$entityManager->flush();
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
            $this->addFlash('error',sprintf('¡Ya existe una caja abierta!'));
            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'Caja'
            ));
        }
        #dump($entity);exit;
        if ($newForm->isSubmitted() && $newForm->isValid()) {
            $this->dispatch(EasyAdminEvents::PRE_PERSIST, array('entity' => $entity));

            $this->executeDynamicMethod('prePersist<EntityName>Entity', array($entity));
            $this->executeDynamicMethod('persist<EntityName>Entity', array($entity));

            $this->dispatch(EasyAdminEvents::POST_PERSIST, array('entity' => $entity));

            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'Caja'
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
?>