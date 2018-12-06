<?php

namespace App\Controller;

use App\Entity\Caja;
use App\Entity\Movimiento;
use App\Entity\Notificacion;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\TableChart;

class CajaController extends AdminController
{
    public function cerrarAction()
    {
        $this->dispatch(EasyAdminEvents::PRE_EDIT);

        $id = $this->request->query->get('id');
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $this->em->getRepository(Caja::class)->find($id);
        $entity->setCierre(new \DateTime());
        $entity->setEmpleadoCierre($this->get('security.token_storage')->getToken()->getUser());

        if ($entity->getEmpleadoCierre()!=$entity->getEmpleadoApertura())
        {
            $noti = new Notificacion();
            $noti->setCreacion(new \DateTime());
            $noti->setDescripcion('La caja abierta por '.$entity->getEmpleadoApertura().' fue cerrada por '.$entity->getEmpleadoCierre());
            $em->persist($noti);
            $this->addFlash('warning',sprintf('Está a punto de cerrar una caja que no fue abierta por usted'));
        }
        
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
    
      
        $em->persist($caja);

        $this->em->flush();

        $this->addFlash('warning',sprintf('Caja cerrada'));

        return $this->redirectToRoute('easyadmin', array(
            'action' => 'list',
            'entity' => 'Caja',
        ));

    }
    
    public function liquidacionAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $cajas = $em->getRepository(Caja::class)->findAll();
        $movimientos = $em->getRepository(Movimiento::class)->findAll();
        
        $min = date('m-01-Y'); // hard-coded '01' for first day
        $max  = date('m-t-Y');
        
        foreach ($cajas as $key => $caja)
        {
            if (($caja->getFecha()<=($max))and($caja->getFecha()>=($min)))
            {
                unset($cajas[$key]);
            }
        }
        foreach ($movimientos as $key => $movimiento)
        {
            if (($movimiento->getHora()<=($max))and($movimiento->getHora()>=($min)))
            {
                unset($movimientos[$key]);
            }
        } 

        if ($movimientos==[] or $cajas ==[])
        {
            $this->addFlash('warning',sprintf('No hay movimientos/cajas'));
            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'Caja'
            ));
        }
        $listacajas = array();
        $elemento = array();
        $elemento = [
            ['label' => 'Mes', 'type' => 'string'],
            ['label' => 'Concepto', 'type' => 'string'],
            ['label' => 'Total', 'type' => 'number']
        ];
        array_push($listacajas, $elemento);

        $listamovimientos = array();
        $elemento = array();
        $elemento = [
            ['label' => 'Momento', 'type' => 'string'],
            ['label' => 'Entrada', 'type' => 'string'],
            ['label' => 'Salida', 'type' => 'string'],
            ['label' => 'Concepto', 'type' => 'string'],
            ['label' => 'Observaciones', 'type' => 'string'],
            ['label' => 'Monto', 'type' => 'number'],
            ['label' => 'Válido', 'type' => 'boolean']
        ];
        array_push($listamovimientos, $elemento);
        $ingresos = 0;
        $egresos = 0;
        foreach ($movimientos as $movimiento)
        {
            if ($movimiento->getValido()==TRUE)
            {
                if ($movimiento->getTipo()=='Ingreso')
                {
                    $ingresos = $ingresos + $movimiento->getMonto();
                }
                else
                {
                    $egresos = $egresos + $movimiento->getMonto();
                }
            }
            $elemento = array();
            array_push($elemento, (string) $movimiento->getHora()->format('d/m/Y H:i:s'));
            if ($movimiento->getTipo()=='Ingreso')
            {
                array_push($elemento, 'Ingreso');
                array_push($elemento, '');
            }
            else
            {
                array_push($elemento, '');
                array_push($elemento, 'Egreso');
            }
            array_push($elemento, $movimiento->getConcepto());
            array_push($elemento, $movimiento->getObservaciones());
            array_push($elemento, ['v' => $movimiento->getMonto(), 'f' => '$'.(string)$movimiento->getMonto()]);
            array_push($elemento, $movimiento->getValido());
            array_push($listamovimientos,$elemento);
        }    
        $now = new \DateTime();
        $elemento = array();
        setlocale(LC_ALL,"es_ES");
        $mesyano =  strftime("%B de %Y",$now->getTimestamp());
        array_push($elemento, $mesyano);
        array_push($elemento, 'Total de ingresos');
        array_push($elemento, ['v' => $ingresos, 'f' => '$'.(string)$ingresos]);            
        array_push($listacajas, $elemento);
        $elemento = array();
        array_push($elemento, $mesyano);
        array_push($elemento, 'Total de egresos');
        array_push($elemento, ['v' => $egresos, 'f' => '$'.(string)$egresos]);            
        array_push($listacajas, $elemento);
        //dump($listacajas);exit;

        $chart1 = new TableChart();
        $chart1->getData()->setArrayToDataTable($listacajas);
        $chart1->getOptions()->setHeight('40%');
        $chart1->getOptions()->setWidth('40%');

        $chart2 = new TableChart();
        $chart2->getData()->setArrayToDataTable($listamovimientos);
        $chart2->getOptions()->setHeight('50%');
        $chart2->getOptions()->setWidth('50%');
        $now =  new \DateTime();

        $nombremes =  strftime("%B",$now->getTimestamp());
        return $this->render('chart2.html.twig', array(
            'chart1' => $chart1,
            'chart2' => $chart2,
            'titulo' => 'Balance mensual de '.$nombremes,
            'fechaimpresion' => ((string)$now->format('Y/m/d H:i'))
        ));
    }
    public function balanceAction()
    {
        $id = $this->request->query->get('id');
        $em = $this->getDoctrine()->getEntityManager();
        $caja = $em->getRepository(Caja::class)->find($id);
        $movimientos = $em->getRepository(Movimiento::class)->findBy(array('Caja' => $caja->getId()));
        
        $balance = array();
        $tablamovimientos = array();
        $totalingresos = 0;
        $totalegresos = 0;
        
        $elemento = [
            ['label' => 'Concepto', 'type' => 'string'],
            ['label' => 'Total', 'type' => 'number']
        ];
        array_push($balance, $elemento);
        
        $elemento = array();
        array_push($elemento, 'Saldo inicial');
        array_push($elemento, ['v' => $caja->getSaldoInicial(), 'f' => '$'.(string)$caja->getSaldoInicial()]);
        array_push($balance, $elemento);
        $elemento = array();
        array_push($elemento, 'Saldo final');
        array_push($elemento, ['v' => $caja->getSaldoFinal(), 'f' => '$'.(string)$caja->getSaldoFinal()]);
        array_push($balance, $elemento);
        
        $elemento = [
            ['label' => 'Momento', 'type' => 'string'],
            ['label' => 'Entrada', 'type' => 'string'],
            ['label' => 'Salida', 'type' => 'string'],
            ['label' => 'Concepto', 'type' => 'string'],
            ['label' => 'Observaciones', 'type' => 'string'],
            ['label' => 'Monto', 'type' => 'number'],
            ['label' => 'Válido', 'type' => 'boolean']
        ];
        array_push($tablamovimientos, $elemento);
        
        if ($movimientos==[])
        {
            $this->addFlash('warning',sprintf('No hay movimientos'));
            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'Caja'
            ));
        }
        foreach ($movimientos as $movimiento)
        {
            $elemento = array();
            array_push($elemento, (string) $movimiento->getHora()->format('H:i:s'));
            if ($movimiento->getTipo()=='Ingreso')
            {
                array_push($elemento, 'Ingreso');
                array_push($elemento, '');
            }
            else
            {
                array_push($elemento, '');
                array_push($elemento, 'Egreso');
            }
            array_push($elemento, $movimiento->getConcepto());
            array_push($elemento, $movimiento->getObservaciones());
            array_push($elemento, ['v' => $movimiento->getMonto(), 'f' => '$'.(string)$movimiento->getMonto()]);
            array_push($elemento, $movimiento->getValido());
            
            if ($movimiento->getTipo()=='Ingreso')
            {
                if($movimiento->getValido())
                {
                    $totalingresos = $totalingresos+$movimiento->getMonto();
                }
            }
            else
            {
                if($movimiento->getValido())
                {
                    $totalegresos = $totalegresos+$movimiento->getMonto();
                }
            }
            array_push($tablamovimientos,$elemento);
        }        
        $final = array();
        $elemento = [
            ['label' => 'Concepto', 'type' => 'string'],
            ['label' => 'Total', 'type' => 'number']
        ];
        array_push($final, $elemento);
        $elemento = array();
        array_push($elemento, 'Total de ingresos');
        array_push($elemento, ['v' => $totalingresos, 'f' => '$'.(string)$totalingresos]);
        array_push($final, $elemento);
        $elemento = array();
        array_push($elemento, 'Total de egresos');
        array_push($elemento, ['v' => $totalegresos, 'f' => '$'.(string)$totalegresos]);
        array_push($final, $elemento);
        $tablas = [new TableChart(),new TableChart(),new TableChart()];
        $tablas[0]->getData()->setArrayToDataTable($balance);
        $tablas[1]->getData()->setArrayToDataTable($tablamovimientos);
        $tablas[2]->getData()->setArrayToDataTable($final);
        foreach ($tablas as $tabla)
        {
            $tabla->getOptions()->setWidth('50%');
            $tabla->getOptions()->setHeight('50%');
        }
        $now =  new \DateTime();
        return $this->render('/informes/informes2.html.twig',
        array('table'=> $tablas[0],
            'chart1' => $tablas[1],
        'chart2' => $tablas[2],
        'titulo' => 'Balance de caja del día '. (string) $caja->getFecha()->format('d/m/Y'),
        'sub1' => 'Apertura y cierre de caja',
        'sub2' => 'Movimientos',
        'sub3' => 'Totales',
        'fechaimpresion' => ((string)$now->format('Y/m/d H:i'))
    ));
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

            $entity->setSaldoFinal($entity->getSaldoInicial());

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
    
    public function addMovAction()
    {

        return $this->redirectToRoute('easyadmin', array(
            'action' => 'new',
            'entity' => 'Movimiento',


        ));

    }


}
?>