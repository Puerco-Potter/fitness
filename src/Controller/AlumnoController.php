<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\Entity\FichaMedica;
use App\Entity\Inscripcion;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\TableChart;

class AlumnoController extends AdminController
{
    public function informeactivosAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $alumnos = $em->getRepository(Alumno::class)->findAll();
        $inscripciones = $em->getRepository(Inscripcion::class)->findAll();

        foreach ($inscripciones as $key => $inscripcion)
        {
            if ($inscripcion->getFechaFin()<=(new \DateTime()))
            {
                unset($inscripciones[$key]);
            }
        }

        foreach ($alumnos as $key1 => $alumno)
        {   
            $resultado = FALSE;
            foreach ($inscripciones as $key2 => $inscripcion)
            {
                if ($inscripcion->getAlumno()->getId()==$alumno->getId())
                {
                    $resultado = TRUE;
                }
            }
            if (!($resultado) or $alumno->getInactivo())
            {
                unset($alumnos[$key1]);
            }
        }
        
        $lista = array();
        $elemento = array();
        $elemento = [
            ['label' => 'DNI', 'type' => 'string'],
            ['label' => 'Nombre y apellido', 'type' => 'string'],
            ['label' => 'Localidad', 'type' => 'string'],
            ['label' => 'Dirección', 'type' => 'string'],
            ['label' => 'Correo', 'type' => 'string'],
            ['label' => 'Teléfono', 'type' => 'string']
        ];
        array_push($lista, $elemento);
        if ($alumnos==[])
        {
            $this->addFlash('warning',sprintf('No hay alumnos activos'));
            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'Alumno'
            ));
        }
        foreach ($alumnos as $alumno)
        {
            $elemento = array();
            array_push($elemento, (string) $alumno->getDNI());
            array_push($elemento, (string) $alumno);
            array_push($elemento, (string) $alumno->getLocalidad());
            array_push($elemento, (string) $alumno->getDireccion());
            array_push($elemento, (string) $alumno->getCorreo());
            #dump($alumno->listaTelefonos());exit;
            array_push($elemento, (string) $alumno->listaTelefonos());
            array_push($lista,$elemento);
        }        
        //dump($lista);exit;
        $chart = new TableChart();
        $chart->getData()->setArrayToDataTable($lista);
        #$chart->getOptions()->setHeight('100%');
        #$chart->getOptions()->setWidth('25%');
        $now =  new \DateTime();
        return $this->render('/informes/informes.html.twig',
        array('chart' => $chart,
        'fechaimpresion' => ((string)$now->format('Y/m/d H:i:s')),
        'titulo' => 'Informe de alumnos activos'));
    }
    public function informemorososAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $alumnos = $em->getRepository(Alumno::class)->findAll();
        
        $lista = array();
        $elemento = array();
        $elemento = [
            ['label' => 'DNI', 'type' => 'string'],
            ['label' => 'Nombre y apellido', 'type' => 'string'],
            ['label' => 'Localidad', 'type' => 'string'],
            ['label' => 'Dirección', 'type' => 'string'],
            ['label' => 'Correo', 'type' => 'string'],
            ['label' => 'Teléfono', 'type' => 'string'],
            ['label' => 'Deuda', 'type' => 'number']
        ];
        array_push($lista, $elemento);
        
        foreach ($alumnos as $key => $alumno)
            {
                if (($alumno->getBalance()>=0))
                {
                    unset($alumnos[$key]);
                }
            }
        if ($alumnos==[])
        {
            $this->addFlash('warning',sprintf('No hay alumnos morosos'));
            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'Alumno'
            ));
        }
        foreach ($alumnos as $alumno)
        {
            $elemento = array();
            array_push($elemento, (string) $alumno->getDNI());
            array_push($elemento, (string) $alumno);
            array_push($elemento, (string) $alumno->getLocalidad());
            array_push($elemento, (string) $alumno->getDireccion());
            array_push($elemento, (string) $alumno->getCorreo());
            #dump($alumno->listaTelefonos());exit;
            array_push($elemento, (string) $alumno->listaTelefonos());
            array_push($elemento, ['v' => $alumno->getBalance(), 'f' => '$'.(string)$alumno->getBalance()]);
            array_push($lista,$elemento);
        }        
        $chart = new TableChart();
        $chart->getData()->setArrayToDataTable($lista);
        #$chart->getOptions()->setHeight('100%');
        #$chart->getOptions()->setWidth('25%');
        $now =  new \DateTime();
        return $this->render('/informes/informes.html.twig',
        array('chart' => $chart,
        'fechaimpresion' => ((string)$now->format('Y/m/d H:i:s')),
        'titulo' => 'Informe de alumnos morosos'));
    }
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
    public function inactivarAction()
    {
        $id = $this->request->query->get('id');
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $this->em->getRepository(Alumno::class)->find($id);
        $entity->setInactivo(TRUE);
        $em->persist($entity);
        $em->flush();

        return $this->redirectToRoute('easyadmin', array(
            'action' => 'list',
            'entity' => $this->request->query->get('entity'),
        ));

    }

    public function activarAction()
    {
        $id = $this->request->query->get('id');
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $this->em->getRepository(Alumno::class)->find($id);
        $entity->setInactivo(FALSE);
        $em->persist($entity);
        $em->flush();

        return $this->redirectToRoute('easyadmin', array(
            'action' => 'list',
            'entity' => $this->request->query->get('entity'),
        ));

    }
    public function irFichaAction()
    {
        $id = $this->request->query->get('id');
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $this->em->getRepository(Alumno::class)->find($id);
        $em->persist($entity);


        $ficha = new FichaMedica();
     
        $ficha->setAlumno($entity); 
        $ficha->setAltura(0);
        $ficha->setPeso(0);
        $ficha->setEnfermedadesCardiacas(0);
        $ficha->setLesionesCronicas(0);
        $ficha->setRehabilitacion(0);
        $ficha->setPerderPeso(0);
        $ficha->setDiabetes(0);
        $ficha->setBajoTratamiento(0);
        $ficha->setDieta(0);
        $ficha->setConoceImc(0);
        $ficha->setProblemasArticulares(0);
        $ficha->setProblemasEspalda(0);
        $ficha->setDolores(0);
        $ficha->setSobrepeso(0);
        $ficha->setHipertenso(0);
        $ficha->setMedicamentos(0);
        $ficha->setEmbarazada(0);
        $ficha->setHernias(0);
        $ficha->setHidratado(0);
        $ficha->setTiempoEmbarazo("-");
        $ficha->setTalla(" ");
        $ficha->setObservaciones("  ");
        $ficha->setTelefonoEmergencia(" ");
        $ficha->setGrupoSanguineo(" ");
        $ficha->setListaMedicamentos("  ");
        $ficha->setListaEnfermedades(" ");
        $ficha->setCirugia(0);

        $em->persist($ficha);
        $em->flush();  

        $highest_id = $ficha->getId();       
        $em->flush();   

        return $this->redirectToRoute('easyadmin', array(
            'action' => 'edit',
            'entity' => 'FichaMedica',
            'id' => $highest_id,

        ));

    }



}