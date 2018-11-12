<?php

namespace App\Controller;

use App\Entity\Alumno;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as coso;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\TableChart;

class AlumnoController extends AdminController
{
    public function informemorososAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $alumnos = $em->getRepository(Alumno::class)->findAll();
        
        $lista = array();
        $elemento = array();
        $elemento = [
            ['label' => 'DNI', 'type' => 'string'],
            ['label' => 'Nombre y apellido', 'type' => 'string'],
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
            array_push($elemento, ['v' => $alumno->getBalance(), 'f' => '$'.(string)$alumno->getBalance()]);
            array_push($lista,$elemento);
        }        
        $chart = new TableChart();
        $chart->getData()->setArrayToDataTable($lista);
        $chart->getOptions()->setHeight('25%');
        $chart->getOptions()->setWidth('25%');
        return $this->render('bar.html.twig', array('chart' => $chart));
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
        $entity = $this->em->getRepository(Alumno::class)->find($id);
        $entity->setInactivo(TRUE);
        $this->em->flush();

        return $this->redirectToRoute('easyadmin', array(
            'action' => 'list',
            'entity' => $this->request->query->get('entity'),
        ));

    }

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