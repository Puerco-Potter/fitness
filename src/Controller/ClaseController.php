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
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\TableChart;

class ClaseController extends AdminController
{
    
    public function alumnosdeclaseAction()
    {
        $id = $this->request->query->get('id');
        $em = $this->getDoctrine()->getEntityManager();
        $clase = $em->getRepository(Clase::class)->find($id);
        $inscripciones = $em->getRepository(Inscripcion::class)->findBy(array('Clase' => $clase->getId()));
        
        foreach ($inscripciones as $key => $inscripcion)
        {
            if ($inscripcion->getFechaFin()<=(new \DateTime()))
            {
                unset($inscripciones[$key]);
            }
        }
        if ($inscripciones==[])
        {
            $this->addFlash('warning',sprintf('No hay alumnos inscriptos a la clase seleccionada'));
            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'Clase'
            ));
        }
        $alumnos = array();
        $elemento = array();
        array_push($elemento, 'DNI');
        array_push($elemento, 'Nombre y apellido');   
        array_push($alumnos, $elemento);  
        foreach ($inscripciones as $inscripcion)
        {
            $elemento = array();
            array_push($elemento, $inscripcion->getAlumno()->getDNI());
            array_push($elemento, (string)$inscripcion->getAlumno());  
            array_push($alumnos, $elemento);  
        }
        $chart = new TableChart();
        $chart->getData()->setArrayToDataTable($alumnos);
        #$chart->getOptions()->setHeight('100%');
        #$chart->getOptions()->setWidth('25%');
        $now =  new \DateTime();
        return $this->render('/informes/informes.html.twig', array('chart' => $chart,
        'fechaimpresion' => ((string)$now->format('Y/m/d H:i')),
        'titulo2' => 'Alumnos inscriptos: ',
        'titulo' => ('Clase de '.(string)$clase->getActividad().
        ' - Prof. '.(string)$clase->getProfesor().
        ' - '.(string)$clase->getDiasCorto().
        ' - '.(string)$clase->getHorario()->format('H:i').'hs')));
    }

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
            $this->addFlash('warning',sprintf('No hay inscripciones en ninguna de las clases'));
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
        
        $lista_tabla = array();
        $elemento = array();
        $elemento = [
            ['label' => 'Clase', 'type' => 'string'],
            ['label' => 'Cantidad de Alumnos', 'type' => 'number'],
            ['label' => 'Ingresos', 'type' => 'number']
        ];
        array_push($lista_tabla, $elemento);

        foreach ($clases as $clase)
        {
            $c_alumnos = array();
            $c_dinero = array();
            $elemento = array();
            array_push($elemento, (string)$clase);
            array_push($c_alumnos, (string)$clase);
            array_push($c_dinero, (string)$clase);
            $contador = 0;
            $dinero = 0;
            foreach ($inscripciones as $inscripcion)
            {
                if ($inscripcion->getClase()->getId()==$clase->getId())
                {
                    $contador = $contador+1;
                    $dinero = $dinero + $inscripcion->getCuota() + $inscripcion->getSaldo();
                    if ($inscripcion->getCombo()!=NULL)
                    {
                        $dinero = $dinero + $inscripcion->getCombo()->getMontoReal() + $inscripcion->getCombo()->getSaldoReal();
                    }
                }
            }
            array_push($c_alumnos, $contador);
            array_push($c_dinero, $dinero);
            array_push($ar_alumnos, $c_alumnos);    
            array_push($ar_dinero, $c_dinero);

            array_push($elemento, ['v' => $contador, 'f' => (string)$contador]);
            array_push($elemento, ['v' => $dinero, 'f' => '$'.(string)$dinero]);
            array_push($lista_tabla, $elemento);

        }
        //dump($resultado);exit;
        
       
        $table = new TableChart();
        $table->getData()->setArrayToDataTable($lista_tabla);    


        $chart1 = new BarChart();
        $chart1->getData()->setArrayToDataTable($ar_alumnos);
        $chart1->getOptions()->setTitle('Informe global de cantidad de Alumnos por Clase');
        $chart1->getOptions()->getHAxis()->setTitle('Cantidad de Alumnos');
        $chart1->getOptions()->getHAxis()->setMinValue(0);
        $chart1->getOptions()->getHAxis()->setFormat('0');
        $chart1->getOptions()->getVAxis()->setTitle('Clases');
        #$chart1->getOptions()->setWidth(900);
        $chart1->getOptions()->setHeight(600);

        $chart2 = new BarChart();
        $chart2->getData()->setArrayToDataTable($ar_dinero);
        $chart2->getOptions()->setTitle('Informe global de ingresos por Clase');
        $chart2->getOptions()->getHAxis()->setTitle('Ingresos');
        $chart2->getOptions()->getHAxis()->setMinValue(0);
        $chart2->getOptions()->getVAxis()->setTitle('Clases');
        #$chart2->getOptions()->setWidth(900);
        $chart2->getOptions()->setHeight(600);
        $now =  new \DateTime();
        #dump($table);exit;

        return $this->render('/informes/informes2.html.twig',
        array('table'=> $table,
            'chart1' => $chart1,
        'chart2' => $chart2,
        'titulo' => 'Informe de Clases',
        'sub1' => 'Cantidad de Alumnos e ingresos por Clase',
        'sub2' => 'Gráficos de cantidad de Alumnos',
        'sub3' => 'Cantidad de ingresos',
        'fechaimpresion' => ((string)$now->format('Y/m/d H:i'))
    ));
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