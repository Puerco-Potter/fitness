<?php

namespace App\Controller;

use App\Entity\Actividad;
use App\Entity\Clase;
use App\Entity\Inscripcion;
use App\Entity\Alumno;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;

class ActividadController extends AdminController
{
    
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

        $resultado = array();
        $coso = array();
        array_push($coso, 'Clases');
        array_push($coso, 'Alumnos');
        array_push($resultado, $coso);        
        foreach ($clases as $clase)
        {
            $coso = array();
            array_push($coso, (string)$clase);
            $contador = 0;
            foreach ($inscripciones as $inscripcion)
            {
                if ($inscripcion->getClase()->getId()==$clase->getId())
                {
                    $contador = $contador+1;
                }
            }
            array_push($coso, $contador);
            array_push($resultado, $coso);
        }


        $bar = new BarChart();
        $bar->getData()->setArrayToDataTable($resultado);
        $bar->getOptions()->setTitle('Cantidad de inscripciones por clases');
        $bar->getOptions()->getHAxis()->setTitle('Alumnos');
        $bar->getOptions()->getHAxis()->setMinValue(0);
        $bar->getOptions()->getVAxis()->setTitle('Clases');
        $bar->getOptions()->setWidth(900);
        $bar->getOptions()->setHeight(500);
        $chart = $bar;
        return $this->render('bar.html.twig', array('chart' => $chart));



    
    }

}
?>