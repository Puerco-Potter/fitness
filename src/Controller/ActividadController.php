<?php

namespace App\Controller;

use App\Entity\Actividad;
use App\Entity\Clase;
use App\Entity\Inscripcion;
use App\Entity\Alumno;
use App\Entity\Combo;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\TableChart;

class ActividadController extends AdminController
{
    public function informeactividadesAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $actividades = $em->getRepository(Actividad::class)->findBy(['estado'=>TRUE]);//All();
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
                'entity' => 'Actividad'
            ));
        }
        $ar_alumnos = array();
        $ar_dinero = array();
        $c_alumnos = array();
        $c_dinero = array();

        $lista_tabla = array();
        $elemento = array();
        $elemento = [
            ['label' => 'Profesor', 'type' => 'string'],
            ['label' => 'Cantidad de alumnos', 'type' => 'number'],
            ['label' => 'Ingresos', 'type' => 'number']
        ];
        array_push($lista_tabla, $elemento);

        array_push($c_alumnos, 'Actividades');
        array_push($c_alumnos, 'Alumnos');
        array_push($c_dinero, 'Actividades');
        array_push($c_dinero, 'Dinero');
        array_push($ar_alumnos, $c_alumnos);    
        array_push($ar_dinero, $c_dinero);        
        foreach ($actividades as $actividad)
        {
            $c_alumnos = array();
            $c_dinero = array();
            $elemento = array();
            array_push($c_alumnos, (string)$actividad);
            array_push($c_dinero, (string)$actividad);
            array_push($elemento, (string)$actividad);
            $contador = 0;
            $dinero = 0;
            foreach ($inscripciones as $inscripcion)
            {
                if ($inscripcion->getClase()->getActividad()->getId()==$actividad->getId())
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
        //dump($lista_tabla);exit;

        $table = new TableChart();
        $table->getData()->setArrayToDataTable($lista_tabla); 

        $chart1 = new BarChart();
        $chart1->getData()->setArrayToDataTable($ar_alumnos);
        $chart1->getOptions()->setTitle('Informe global de cantidad de alumnos por actividad');
        $chart1->getOptions()->getHAxis()->setTitle('Cantidad de alumnos');
        $chart1->getOptions()->getHAxis()->setMinValue(0);
        $chart1->getOptions()->getHAxis()->setFormat('0');
        $chart1->getOptions()->getVAxis()->setTitle('Actividades');
        #$chart1->getOptions()->setWidth(900);
        #$chart1->getOptions()->setHeight(1000);

        $chart2 = new BarChart();
        $chart2->getData()->setArrayToDataTable($ar_dinero);
        $chart2->getOptions()->setTitle('Informe global de ingresos por actividad');
        $chart2->getOptions()->getHAxis()->setTitle('Ingresos');
        $chart2->getOptions()->getHAxis()->setMinValue(0);
        $chart1->getOptions()->getHAxis()->setFormat('0');
        $chart2->getOptions()->getVAxis()->setTitle('Actividades');
        #$chart2->getOptions()->setWidth(900);
        #$chart2->getOptions()->setHeight(1000);

        $now =  new \DateTime();
        return $this->render('/informes/informes2.html.twig',
        array('table'=> $table,
            'chart1' => $chart1,
        'chart2' => $chart2,
        'titulo' => 'Informe de profesores',
        'sub1' => 'Cantidad de alumnos e ingresos por actividad',
        'sub2' => 'Gráficos de cantidad de alumnos',
        'sub3' => 'Cantidad de ingresos',
        'fechaimpresion' => ((string)$now->format('Y/m/d H:i:s'))
    ));
    }
    
    public function informarAction()
    {
        $id = $this->request->query->get('id');
        $em = $this->getDoctrine()->getEntityManager();
        $actividad = $em->getRepository(Actividad::class)->find($id);
        $clases = $em->getRepository(Clase::class)->findBy(array('Actividad' => $actividad->getId()));
        $clasesIds = array();
        foreach($clases as $clase)
        {       
            array_push($clasesIds, $clase->getId());
        }

        $inscripciones = $em->getRepository(Inscripcion::class)->findBy(array('Clase' => $clasesIds));
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
                'entity' => 'Actividad'
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
            ['label' => 'Cantidad de alumnos', 'type' => 'number'],
            ['label' => 'Ingresos', 'type' => 'number']
        ];
        array_push($lista_tabla, $elemento);  
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
            $elemento = array();            
            array_push($elemento, (string)$clase);
            array_push($elemento, ['v' => $contador, 'f' => (string)$contador]);
            array_push($elemento, ['v' => $dinero, 'f' => '$'.(string)$dinero]);
            array_push($lista_tabla, $elemento);  
        }
        //dump($resultado);exit;
        $table = new TableChart();
        $table->getData()->setArrayToDataTable($lista_tabla);  


        $chart1 = new BarChart();
        $chart1->getData()->setArrayToDataTable($ar_alumnos);
        $chart1->getOptions()->setTitle('Informe por clases de '.$actividad->getNombre());
        $chart1->getOptions()->getHAxis()->setTitle('Cantidad de alumnos');
        $chart1->getOptions()->getHAxis()->setMinValue(0);
        $chart1->getOptions()->getHAxis()->setFormat('0');
        $chart1->getOptions()->getVAxis()->setTitle('Clases');
        $chart1->getOptions()->setWidth(900);
        $chart1->getOptions()->setHeight(500);

        $chart2 = new BarChart();
        $chart2->getData()->setArrayToDataTable($ar_dinero);
        $chart2->getOptions()->setTitle('Informe por clases de '.$actividad->getNombre());
        $chart2->getOptions()->getHAxis()->setTitle('Ingresos');
        $chart2->getOptions()->getHAxis()->setMinValue(0);
        $chart2->getOptions()->getVAxis()->setTitle('Clases');
        $chart2->getOptions()->setWidth(900);
        $chart2->getOptions()->setHeight(500);

        $now =  new \DateTime();

        return $this->render('/informes/informes2.html.twig',
        array('table'=> $table,
            'chart1' => $chart1,
        'chart2' => $chart2,
        'titulo' => 'Informe de las clases de '.(string)$actividad,
        'sub1' => 'Cantidad de alumnos e ingresos',
        'sub2' => 'Gráfico de cantidad de alumnos',
        'sub3' => 'Gráfico de ingresos',
        'fechaimpresion' => ((string)$now->format('Y/m/d H:i:s'))
    ));
    }

}
?>