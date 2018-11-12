<?php

namespace App\Controller;
use App\Entity\Profesor;
use App\Entity\ESEmpleado;
use App\Entity\Actividad;
use App\Entity\Clase;
use App\Entity\Inscripcion;
use App\Entity\Alumno;
use App\Entity\Combo;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use DateInterval;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;

class ClaseController extends AdminController
{
    public function informeclasesAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $clases = $em->getRepository(Clase::class)->findAll();
        $inscripciones = $em->getRepository(Inscripcion::class)->findAll();
        foreach ($inscripciones as $key => $inscripcion)
        {
            if ($inscripcion->getFechaFin()<=(new \DateTime()))
            {
                unset($inscripciones[$key]);
            }
        }
        if ($inscripciones==[])
        {
            $this->addFlash('warning',sprintf('No hay inscripciones'));
            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'Clase'
            ));
        }
        $ar_alumnos = array();
        $ar_dinero = array();
        $c_alumnos = array();
        $c_dinero = array();
        array_push($c_alumnos, 'Clases');
        array_push($c_alumnos, 'Alumnos');
        array_push($c_dinero, 'Clases');
        array_push($c_dinero, 'Dinero');
        array_push($ar_alumnos, $c_alumnos);    
        array_push($ar_dinero, $c_dinero);        
        foreach ($clases as $clase)
        {
            $c_alumnos = array();
            $c_dinero = array();
            array_push($c_alumnos, (string)$clase);
            array_push($c_dinero, (string)$clase);
            $contador = 0;
            $dinero = 0;
            foreach ($inscripciones as $inscripcion)
            {
                if ($inscripcion->getClase()->getId()==$clase->getId())
                {
                    $contador = $contador+1;
                    $dinero = $dinero + $inscripcion->getCuota();
                    if ($inscripcion->getCombo()!=NULL)
                    {
                        $dinero = $dinero + $inscripcion->getCombo()->getMonto();
                    }
                }
            }
            array_push($c_alumnos, $contador);
            array_push($c_dinero, $dinero);
            array_push($ar_alumnos, $c_alumnos);    
            array_push($ar_dinero, $c_dinero);    
        }
        //dump($resultado);exit;


        $chart1 = new BarChart();
        $chart1->getData()->setArrayToDataTable($ar_alumnos);
        $chart1->getOptions()->setTitle('Informe global de cantidad de alumnos de clases');
        $chart1->getOptions()->getHAxis()->setTitle('Cantidad de alumnos');
        $chart1->getOptions()->getHAxis()->setMinValue(0);
        $chart1->getOptions()->getVAxis()->setTitle('Clases');
        $chart1->getOptions()->setWidth(900);
        $chart1->getOptions()->setHeight(1000);

        $chart2 = new BarChart();
        $chart2->getData()->setArrayToDataTable($ar_dinero);
        $chart2->getOptions()->setTitle('Informe global de dinero recaudado de clases');
        $chart2->getOptions()->getHAxis()->setTitle('Dinero recaudado');
        $chart2->getOptions()->getHAxis()->setMinValue(0);
        $chart2->getOptions()->getVAxis()->setTitle('Clases');
        $chart2->getOptions()->setWidth(900);
        $chart2->getOptions()->setHeight(1000);

        return $this->render('chart2.html.twig', array('chart1' => $chart1, 'chart2' => $chart2));
    }
    /*
    public function informarAction()
    {
    $em->getDoctrine()
        ->getRepository(AsistenciaAlumno::class)->getEntityManager();
        ->findBy(array('Inscripcion' => $id, 'fecha' => $dia));
    }
    */
    
}