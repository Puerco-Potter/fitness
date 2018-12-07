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
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\TableChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;


class ProfesorController extends AdminController
{
/*
SELECT clase.id as 'CLASE',COUNT(alumno.id) AS 'NumeroDeAlumnos'
FROM
profesor
INNER JOIN clase ON profesor.id=clase.profesor_id
INNER JOIN inscripcion ON clase.id=inscripcion.clase_id
INNER JOIN alumno ON alumno.id=inscripcion.alumno_id
WHERE inscripcion.fecha_inscripcion BETWEEN '2010-09-29 10:15:55' AND '2018-11-6 14:15:55'
GROUP BY clase.id
*/
    public function informeprofesoresAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $profesores = $em->getRepository(Profesor::class)->findAll();
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
            $this->addFlash('warning',sprintf('No hay inscripciones, no se puede realizar el Informe'));
            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'Clase'
            ));
        }
        foreach ($profesores as $key1 => $profesor)
        {   
            $resultado = FALSE;
            foreach ($inscripciones as $key2 => $inscripcion)
            {
                if ($inscripcion->getClase()->getProfesor()->getId()==$profesor->getId())
                {
                    $resultado = TRUE;
                }
            }
            if (!($resultado))
            {
                unset($profesores[$key1]);
            }
        }
        //dump($profesores);exit;
        if ($profesores==[])
        {
            $this->addFlash('warning',sprintf('No hay profesores con alumnos inscriptos, no se puede realizar el Informe'));
        }

        $ar_alumnos = array();
        $ar_dinero = array();
        $c_alumnos = array();
        $c_dinero = array();

        array_push($c_alumnos, 'Profesores');
        array_push($c_alumnos, 'Alumnos');
        array_push($c_dinero, 'Profesores');
        array_push($c_dinero, 'Dinero');
        array_push($ar_alumnos, $c_alumnos);    
        array_push($ar_dinero, $c_dinero);   
        
        $lista_tabla = array();
        $elemento = array();
        $elemento = [
            ['label' => 'Profesor', 'type' => 'string'],
            ['label' => 'Cantidad de Alumnos', 'type' => 'number'],
            ['label' => 'Ingresos', 'type' => 'number']
        ];
        array_push($lista_tabla, $elemento);

        foreach ($profesores as $profesor)
        {
            $c_alumnos = array();
            $c_dinero = array();
            $elemento = array();
            array_push($c_alumnos, (string)$profesor);
            array_push($c_dinero, (string)$profesor);
            array_push($elemento, (string)$profesor);
            $contador = 0;
            $dinero = 0;
            foreach ($inscripciones as $inscripcion)
            {
                if ($inscripcion->getClase()->getProfesor()->getId()==$profesor->getId())
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
        $chart1->getOptions()->setTitle('Informe global de cantidad de Alumnos por Profesor');
        $chart1->getOptions()->getHAxis()->setTitle('Cantidad de Alumnos');
        $chart1->getOptions()->getHAxis()->setMinValue(0);
        $chart1->getOptions()->getHAxis()->setFormat('0');
        $chart1->getOptions()->getVAxis()->setTitle('Profesores');
        #$chart1->getOptions()->setWidth(900);
        $chart1->getOptions()->setHeight(400);

        $chart2 = new BarChart();
        $chart2->getData()->setArrayToDataTable($ar_dinero);
        $chart2->getOptions()->setTitle('Informe global de ingresos por Profesor');
        $chart2->getOptions()->getHAxis()->setTitle('Ingresos');
        $chart2->getOptions()->getHAxis()->setMinValue(0);
        $chart1->getOptions()->getHAxis()->setFormat('0');
        $chart2->getOptions()->getVAxis()->setTitle('Profesores');
        #$chart2->getOptions()->setWidth(900);
        $chart2->getOptions()->setHeight(400);
        $now =  new \DateTime();

        return $this->render('/informes/informes2.html.twig',
        array('table'=> $table,
            'chart1' => $chart1,
        'chart2' => $chart2,
        'titulo' => 'Informe de Profesores',
        'sub1' => 'Cantidad de Alumnos e ingresos por Profesor',
        'sub2' => 'Gráficos de cantidad de Alumnos',
        'sub3' => 'Cantidad de ingresos',
        'fechaimpresion' => ((string)$now->format('Y/m/d H:i'))
    ));
    }
    public function asistenciasAction()
    {
        $id = $this->request->query->get('id');
        $em = $this->getDoctrine()->getEntityManager();
        $profesor = $em->getRepository(Profesor::class)->find($id);
        $eses = $em->getRepository(ESEmpleado::class)->findBy(array('Empleado' => $profesor->getId()));
        
        $now = new \DateTime();

        $first_day_this_month = date('m-01-Y', strtotime("-1 months")); // hard-coded '01' for first day
        $last_day_this_month  = date("m-t-Y");#date('m-t-Y');
        #dump($last_day_this_month);exit;

        $min = $first_day_this_month;
        $max = $last_day_this_month;
        if ($eses !=[])
        {
            foreach ($eses as $key => $ese)
            {
                if (($ese->getFechaYHora()<=$max) AND ($ese->getFechaYHora()>=$min))
                {
                    unset($eses[$key]);
                }
            }
        }
        #dump($eses);exit;

        if ($eses==[])
        {
            $this->addFlash('warning',sprintf('No hay registros de Entradas/Salidas de este profesor'));
            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'Profesor'
            ));
        }
        $lista = array();
        $elemento = array();
        array_push($elemento, 'Día');
        array_push($elemento, 'Horario');
        array_push($elemento, 'Tipo');
        //array_push($elemento, 'Tipo');
        array_push($lista, $elemento);  
        
        
        /*
        $dia = (int) $max[3].$max[4];
        foreach( range(1, $dia) as $numero)
        {
            $elemento = array();

            
        }
        */

        foreach ($eses as $ese)
        {
            $elemento = array();
            //setlocale(LC_ALL,"es_ES");
            //$dia =  (string)idate('d',$ese->getFechaYHora()->getTimestamp());
            //$mes =  strftime("%B",$ese->getFechaYHora()->getTimestamp());
            //$diames = (string)$dia.' de '.$mes;
            $dia =(string)$ese->getFechaYHora()->format('Y/m/d');
            array_push($elemento, $dia);
            $hora =(string)$ese->getFechaYHora()->format('H:i:s');
            array_push($elemento, $hora);
            array_push($elemento, $ese->getTipo());
            array_push($lista, $elemento);
        }
        //dump($lista);exit;
        $chart = new TableChart();
        $chart->getData()->setArrayToDataTable($lista);

        return $this->render('informes/informes.html.twig',
        array('chart' => $chart,
        'titulo2'=> '',
        'titulo'=> 'Entradas y salidas de "'.(string)$profesor.'" durante los 2 últimos meses',
        'fechaimpresion' => ((string)$now->format('Y/m/d H:i'))
    ));



    }

    public function informarAction()
    {
        $id = $this->request->query->get('id');
        $em = $this->getDoctrine()->getEntityManager();
        $profesor = $em->getRepository(Profesor::class)->find($id);
        $clases = $em->getRepository(Clase::class)->findBy(array('Profesor' => $profesor->getId()));
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
            $this->addFlash('warning',sprintf('No hay alumnos inscriptos a su/s clase/s, no se puede realizar el Informe'));
            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'Profesor'
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
        $chart1->getOptions()->setTitle('Informe por clases activas de '.(string)$profesor);
        $chart1->getOptions()->getHAxis()->setTitle('Cantidad de Alumnos');
        $chart1->getOptions()->getHAxis()->setMinValue(0);
        $chart1->getOptions()->getHAxis()->setFormat('0');
        $chart1->getOptions()->getVAxis()->setTitle('Clases');
        $chart1->getOptions()->setWidth(900);
        $chart1->getOptions()->setHeight(500);

        $chart2 = new BarChart();
        $chart2->getData()->setArrayToDataTable($ar_dinero);
        $chart2->getOptions()->setTitle('Informe por Clases activas de '.(string)$profesor);
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
        'titulo' => 'Informe de las Clases de '.(string)$profesor,
        'sub1' => 'Cantidad de Alumnos e ingresos',
        'sub2' => 'Gráfico de cantidad de Alumnos',
        'sub3' => 'Gráfico de ingresos',
        'fechaimpresion' => ((string)$now->format('Y/m/d H:i'))
    ));
        /*
        $id = $this->request->query->get('id');
        $em = $this->getDoctrine()->getEntityManager();
        $p = $em->getRepository(Profesor::Class)->find($id);

        $qb = $em->createQueryBuilder();
        $now = new \DateTime();
        $treinta = (new \DateTime())->sub(new DateInterval('P30D'));
        $resultados = $qb
        ->addSelect('COUNT(a.id) as count')
        ->addSelect('c.id')
        ->from('App\Entity\Profesor','p')
        ->innerjoin('App\Entity\Clase','c','WITH','c.Profesor = p.id')
        ->innerjoin('App\Entity\Inscripcion','i','WITH','c.id = i.Clase')
        ->innerjoin('App\Entity\Alumno','a','WITH','a.id = i.Alumno')
        ->groupBy('c.id')
        ->add('where', $qb->expr()->between(
            'i.fechaInscripcion',
            ':from',
            ':to'
            )
        )
        ->setParameters(array('from' => $treinta, 'to' => $now))
        ->andWhere('p.id = :id')
        ->setParameter('id',$id)
        ->getQuery()
        ->getResult();
        //dump($resultados);exit;
        $labels = '';
        $valores = '';
        //dump($resultados);exit;
        if ($resultados != [])
        {
            foreach ($resultados as &$coso)
            {
                $labels = $labels.(string)$coso['id'].'|';
                $valores = $valores.(string)$coso['count'].',';
            }
            $labels = substr_replace($labels ,'', -1);
            $valores = substr_replace($valores ,'', -1);
        $url = 'https://chart.googleapis.com/chart?cht=bvg&chs=200x200&';
        $url = $url.'chd=t:'.$valores.'&';
        $url = $url.'chl='.$labels;
        //dump($url);exit;

        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Write(11,utf8_decode('Cantidad de alumnos en los últimos días de: '));
        $pdf->Ln(10);
        $pdf->Write(11,utf8_decode((string)$p));
        $pdf->Ln(10);
        //$pdf->Write(11,utf8_decode($url));
        //$pdf->Ln(10);
        $pdf->Image($url,60,30,0,0,'PNG');
        return new Response($pdf->Output(), 200, array(
            'Content-Type' => 'application/pdf'));
        }
        else
        {
            $this->addFlash('error',sprintf('No hay suficientes datos'));
            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'Profesor'
            ));
        }
    */
    }
}