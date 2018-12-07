<?php

namespace App\Controller;

use App\Entity\PagoCuota;
use App\Entity\Alumno;
use App\Entity\Movimiento;
use App\Entity\Caja;
use App\Entity\Inscripcion;
use App\Entity\Combo;
use DateTime;
use DateTimeInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PagoCuotaController extends AdminController
{
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

        if ($cajas ==[])
        {
            $this->addFlash('error',sprintf('No hay ninguna Caja abierta, debe abrir una Caja para poder registrar Pagos'));
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
                'entity' => 'PagoCuota'
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

    public function prePersistEntity($entity)
    {
        parent::prePersistEntity($entity);
        if ($entity->getInscripcion()!=NULL)
        {
            $id = $entity->getInscripcion()->getAlumno()->getId();
            $monto = $entity->getMonto();
        }
        else
        {
            $id = $entity->getCombo()->getAlumno()->getId();
            $monto = $entity->getMonto();
        }
        $cajero = $this->get('security.token_storage')->getToken()->getUser();
        
        $entity->setCajero($cajero);
		
        $em = $this->getDoctrine()->getEntityManager();
        $mov = new Movimiento();
        $mov->setHora($entity->getFechaYHora());
        $mov->setConcepto('Cuota');
        $mov->setMonto($entity->getMonto());
        $mov->setTipo('Ingreso');
        if ($entity->getInscripcion() == NULL)
        {
            $mov->setObservaciones((string)$entity->getCombo().' - '.(string)$entity->getCombo()->getAlumno());
        }
        else
        {
            $mov->setObservaciones((string)$entity->getInscripcion()->getClase().' - '.(string)$entity->getInscripcion()->getAlumno());
        }
        
        
        $mov->setEmpleado($entity->getCajero());
        
        
        $rep = $em->getRepository('App\Entity\Caja');
        $results = $rep->findBy(array(),array('id'=>'DESC'),1,0);

        $mov->setCaja($results[0]);
        
        $em->persist($mov);

        $caja = $em->getRepository(Caja::class)->find($mov->getCaja()->getId());
        if ($mov->getTipo()=='Ingreso')
        {
            $caja->setSaldoFinal($caja->getSaldoFinal() + $entity->getMonto());
        }
        else
        {
            $caja->setSaldoFinal($caja->getSaldoFinal() - $entity->getMonto());
        }
      
        $em->persist($caja);

        $entity->setMovimiento($mov);
        $em->persist($entity);

        if($entity->getInscripcion()!=NULL)
        {
            $iid = $entity->getInscripcion();
            $a = ($em->getRepository(Alumno::class)->findBy(array('id' => $entity->getInscripcion()->getAlumno()->getId())))[0];
        }
        else
        {
            $iid = $entity->getCombo();
            $a = ($em->getRepository(Alumno::class)->findBy(array('id' => $entity->getCombo()->getAlumno()->getId())))[0];
        }
        
        $a->setBalance($a->getBalance()+$entity->getMonto());
        $em->persist($a);

        if($entity->getInscripcion()!=NULL)
        {
            $i = ($em->getRepository(Inscripcion::class)->findBy(array('id' => $iid->getId())))[0];
        }
        else
        {
            $i = ($em->getRepository(Combo::class)->findBy(array('id' => $iid->getId())))[0];
        }

        $i->setSaldo($i->getSaldo()+$entity->getMonto());
        $em->persist($i);
        $em->flush();
        
        /*
        $qb = $em->createQueryBuilder();
        $qb->update('App\Entity\Alumno','a')
            ->set('a.balance','a.balance + '.(string)$monto)
            ->where('a.id = '.(string)$id);
        return $qb->getQuery()->getResult();
        */
        /*
		$qqb = $em->createQueryBuilder();
		$qqb->update('App\Entity\PagoCuota','p')
            ->set('p.cajero', "'".(string)$cajero."'")
            ->where('p.id = '.$entity->getId());
        return $qqb->getQuery()->getResult();
        */
    }

    public function imprComprAction()
    {
        $id = $this->request->query->get('id');
        $em = $this->getDoctrine()->getEntityManager();
        $pagoCuota = $em->getRepository(PagoCuota::class)->find($id);
        $inscrPago = $pagoCuota->getInscripcion();
        $now =  new \DateTime();
        $cadena = ' ';
        if ($inscrPago == NULL)
        {
            $comboPago = $pagoCuota->getCombo();
             if ($comboPago == NULL)
            {     
            $this->addFlash('warning',sprintf('No se cargó la inscripción o el combo, verifíquelo y vuelva a intentarlo'));
            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'PagoCuota'
            )); }
                  foreach ($comboPago->getInscripciones() as $x)
                 {
                    $cadena = $cadena.((string)$x->getClase()->getActividad()).' + ';
                 }
                 $cadena = mb_substr($cadena, 0, -1);
                 $cadena = mb_substr($cadena, 0, -1);
            return $this->render('informes/Compr.html.twig',
        array(

        'titulo'=> 'Comprobante de pago ',
        'codigo' => (string)$pagoCuota->getId(),
        'nroCuenta' => (string)$pagoCuota->getCombo()->getAlumno()->getCuenta(),
        'alumno' => (string)$pagoCuota->getCombo()->getAlumno(),
        'dniAlu' => (string)$pagoCuota->getCombo()->getAlumno()->getDni(),
        'inscrPago' => '-',
        'comboPago' => (string)$cadena,
        'diaPago' => $pagoCuota->getFechaYHora()->format('Y/m/d'),
        'horaPago'=> $pagoCuota->getFechaYHora()->format('H:i'),
        'monto' => (string)$pagoCuota->getMonto(),
        'mes' => (string)$pagoCuota->getMes(),
        'anio' => (string)$pagoCuota->getAno(),
        'fechaimpresion' => ((string)$now->format('Y/m/d - H:i'))
         ));

        }


        return $this->render('informes/Compr.html.twig',
        array(
        'titulo'=> 'Comprobante de pago ',
        'codigo' => (string)$pagoCuota->getId(),
        'alumno' => (string)$pagoCuota->getInscripcion()->getAlumno(),
        'nroCuenta' => (string)$pagoCuota->getInscripcion()->getAlumno()->getCuenta(),
        'dniAlu' => (string)$pagoCuota->getInscripcion()->getAlumno()->getDni(),
        'inscrPago' => (' '.(string)$pagoCuota->getInscripcion()->getClase()->getActividad().
        ' - Prof. '.(string)$pagoCuota->getInscripcion()->getClase()->getProfesor().
        ' - '.(string)$pagoCuota->getInscripcion()->getClase()->getDiasCorto().
        ' - '.(string)$pagoCuota->getInscripcion()->getClase()->getHorario()->format('H:i').'hs'),

        'comboPago' => '-',
        'diaPago' => $pagoCuota->getFechaYHora()->format('Y/m/d'),
        'horaPago'=> $pagoCuota->getFechaYHora()->format('H:i'),
        'monto' => (string)$pagoCuota->getMonto(),
        'mes' => (string)$pagoCuota->getMes(),
        'anio' => (string)$pagoCuota->getAno(),
        'fechaimpresion' => ((string)$now->format('Y/m/d - H:i'))
        ));
    }



    /*public function persistEntity($entity)
    {
        parent::persistEntity($entity);
        $em = $this->getDoctrine()->getEntityManager();
        $mov = new Movimiento();
        $mov->setHora($entity->getFechaYHora());
        $mov->setConcepto('Cuota');
        $mov->setMonto($entity->getMonto());
        $mov->setTipo('Ingreso');
        $mov->setObservaciones((string)$entity->getInscripcion()->getClase().' - '.(string)$entity->getInscripcion()->getAlumno());
        $mov->setEmpleado($entity->getCajero());
        
        
        $rep = $em->getRepository('App\Entity\Caja');
        $results = $rep->findBy(array(),array('id'=>'DESC'),1,0);
        $em = $this->getDoctrine()->getEntityManager();


        $mov->setCaja($results[0]);

        
    }*/ //Revisar esto porque no permite registrar Pagos de Cuotas.
}