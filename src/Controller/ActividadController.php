<?php

namespace App\Controller;

use App\Entity\Actividad;
use App\Entity\Clase;
use App\Entity\Inscripcion;
use App\Entity\Alumno;
use App\Entity\Combo;
use App\Entity\PagoCuota;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use \DateTime;
use \Date;
use DateInterval;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\TableChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\LineChart;

class ActividadController extends AdminController
{
    public function historicoActividadesAction()
    {
        $id = $this->request->query->get('id');
        $em = $this->getDoctrine()->getEntityManager();
        $actividad = $em->getRepository(Actividad::class)->find($id);

        $min = date('m-01-Y', strtotime("-5 months")); // hard-coded '01' for first day
        $max  = date("m-t-Y");#date('m-t-Y');

        $now = new \DateTime();
        $pagocuotas = $em->getRepository(PagoCuota::class)->findAll();

        $tabla = array();
        $elemento = array();
        $elemento = [
            ['label' => 'Mes', 'type' => 'string'],
            ['label' => 'Ingresos', 'type' => 'number']
        ];
        array_push($tabla, $elemento);

        foreach ($pagocuotas as $key => $pagocuota)
        {
            if ($pagocuota->getInscripcion()!=NULL)
            {
                if ($pagocuota->getInscripcion()->getClase()->getActividad()->getId()!=$id)
                {
                    unset($pagocuotas[$key]);
                }
            }
            else
            {
                $bandera = FALSE;
                foreach ($pagocuota->getCombo()->getInscripciones() as $key => $inscripcion)
                {
                    if ($inscripcion->getClase()->getActividad()->getId()==$id)
                    {
                        $bandera = TRUE;
                    }
                }
                if (!$bandera)
                {
                    unset($pagocuotas[$key]);
                }
            }
        }
        if ($pagocuotas==[])
        {
            $this->addFlash('warning',sprintf('No hay datos históricos'));
            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'Actividad'
            ));
        }
        $min = DateTime::createFromFormat('m-d-Y', $min);
        $max = DateTime::createFromFormat('m-d-Y', $max);
        $temporal = $min;
        $mesinicial = idate('m',$min->getTimeStamp());
        $mesactual = idate('m',$now->getTimeStamp());
        $meses = array();
        array_push($meses,idate('m',$min->getTimeStamp()));

        
        for ($i = $mesinicial; $i < $mesactual;$i++)
        {
            $temporal->add(new DateInterval('P01M'));
            $coso = idate('m',$temporal->getTimeStamp());
            array_push($meses,$coso);

        }
        //dump($meses);exit;

        $dineros = array();
        foreach ($meses as $mes)
        {
            $elemento = array();
            array_push($elemento,(string)$mes);
            $acumulador = 0;
            foreach ($pagocuotas as $key => $pagocuota)
            {
                if (($pagocuota->getInscripcion()!=NULL) and ($mes==idate('m',$pagocuota->getFechaYHora()->getTimeStamp())))
                {
                    $acumulador = $acumulador + $pagocuota->getMonto();
                }
                if (($pagocuota->getCombo()!=NULL) and ($mes==idate('m',$pagocuota->getFechaYHora()->getTimeStamp())))
                {
                    $acumulador = $acumulador + (($pagocuota->getMonto())/count($pagocuota->getCombo()->getInscripciones()));
                }
            }      
            array_push($dineros,$acumulador);
            array_push($elemento, ['v' => $acumulador, 'f' => '$ '.(string)$acumulador]);
            array_push($tabla,$elemento);
        }
        $final = array();
        $elto = array();
        array_push($elto,'Mes');
        array_push($elto,'Ingresos por cuotas');
        array_push($final,$elto);
        for($i = 0; $i<count($meses);$i++)
        {
            $elto = array();
            array_push($elto,(String)$meses[$i]);
            array_push($elto,$dineros[$i]);
            array_push($final,$elto);
        }
        //dump($final);exit;
        
        $table = new TableChart();
        $table->getData()->setArrayToDataTable($tabla); 

        $chart2 = new BarChart();
        $chart2->getData()->setArrayToDataTable($final);
        $chart2->getOptions()->setTitle('Ingresos de los últimos meses');
        $chart2->getOptions()->getHAxis()->setTitle('Ingresos');
        $chart2->getOptions()->getHAxis()->setMinValue(0);
        $chart2->getOptions()->getHAxis()->setFormat('0');
        $chart2->getOptions()->getVAxis()->setTitle('Meses');
        #$chart1->getOptions()->setWidth(900);
        $chart2->getOptions()->setHeight(400);

        $chart1 = new LineChart();
        $chart1->getData()->setArrayToDataTable($final);
        $chart1->getOptions()->setTitle('Ingresos de los últimos meses');
        $chart1->getOptions()->setSeries([['axis' => 'Temps'], ['axis' => 'Daylight']]);
        
        #$chart1->getOptions()->setWidth(900);
        $chart1->getOptions()->setHeight(400);

        $now =  new \DateTime();
        return $this->render('/informes/informes22.html.twig',
        array('table'=> $table,
            'chart1' => $chart2,
        'titulo' => 'Informe histórico de '.$actividad->getNombre(),
        'sub1' => 'Ingresos históricos de '.$actividad->getNombre(),
        'sub2' => 'Gráfico comparativo',
        'fechaimpresion' => ((string)$now->format('Y/m/d - H:i'))
    ));
    }

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
            $this->addFlash('warning',sprintf('No hay inscripciones activas en ninguna clase, de ninguna actividad'));
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
            ['label' => 'Actividad', 'type' => 'string'],
            ['label' => 'Cantidad de Alumnos', 'type' => 'number'],
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
        $chart1->getOptions()->setTitle('Informe global de cantidad de Alumnos por Actividad');
        $chart1->getOptions()->getHAxis()->setTitle('Cantidad de Alumnos');
        $chart1->getOptions()->getHAxis()->setMinValue(0);
        $chart1->getOptions()->getHAxis()->setFormat('0');
        $chart1->getOptions()->getVAxis()->setTitle('Actividades');
        #$chart1->getOptions()->setWidth(900);
        $chart1->getOptions()->setHeight(400);

        $chart2 = new BarChart();
        $chart2->getData()->setArrayToDataTable($ar_dinero);
        $chart2->getOptions()->setTitle('Informe global de ingresos por Actividad');
        $chart2->getOptions()->getHAxis()->setTitle('Ingresos');
        $chart2->getOptions()->getHAxis()->setMinValue(0);
        $chart1->getOptions()->getHAxis()->setFormat('0');
        $chart2->getOptions()->getVAxis()->setTitle('Actividades');
        #$chart2->getOptions()->setWidth(900);
        $chart2->getOptions()->setHeight(400);

        $now =  new \DateTime();
        return $this->render('/informes/informes2.html.twig',
        array('table'=> $table,
            'chart1' => $chart1,
        'chart2' => $chart2,
        'titulo' => 'Informe de Actividades',
        'sub1' => 'Cantidad de Alumnos e ingresos por Actividad',
        'sub2' => 'Gráficos de cantidad de Alumnos',
        'sub3' => 'Cantidad de ingresos',
        'fechaimpresion' => ((string)$now->format('Y/m/d - H:i'))
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
            $this->addFlash('warning',sprintf('No hay inscripciones en ninguna de las clases de esta actividad'));
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
            ['label' => 'Cantidad de Alumnos', 'type' => 'number'],
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
        $chart1->getOptions()->setTitle('Informe por Clases de '.$actividad->getNombre());
        $chart1->getOptions()->getHAxis()->setTitle('Cantidad de Alumnos');
        $chart1->getOptions()->getHAxis()->setMinValue(0);
        $chart1->getOptions()->getHAxis()->setFormat('0');
        $chart1->getOptions()->getVAxis()->setTitle('Clases');
        $chart1->getOptions()->setWidth(900);
        $chart1->getOptions()->setHeight(400);

        $chart2 = new BarChart();
        $chart2->getData()->setArrayToDataTable($ar_dinero);
        $chart2->getOptions()->setTitle('Informe por Clases de '.$actividad->getNombre());
        $chart2->getOptions()->getHAxis()->setTitle('Ingresos');
        $chart2->getOptions()->getHAxis()->setMinValue(0);
        $chart2->getOptions()->getVAxis()->setTitle('Clases');
        $chart2->getOptions()->setWidth(900);
        $chart2->getOptions()->setHeight(400);

        $now =  new \DateTime();

        return $this->render('/informes/informes2.html.twig',
        array('table'=> $table,
            'chart1' => $chart1,
        'chart2' => $chart2,
        'titulo' => 'Informe de las Clases de '.(string)$actividad,
        'sub1' => 'Cantidad de Alumnos e ingresos',
        'sub2' => 'Gráfico de cantidad de Alumnos',
        'sub3' => 'Gráfico de ingresos',
        'fechaimpresion' => ((string)$now->format('Y/m/d - H:i'))
    ));
    }

}
?>