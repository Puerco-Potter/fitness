<?php

namespace App\Controller;

use App\Entity\Equipamiento;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\TableChart;

class EquipamientoController extends AdminController
{
    public function informeequipamientosAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $equipamientos = $em->getRepository(Equipamiento::class)->findAll();
        foreach ($equipamientos as $key => $equipamiento)
        {
            if ($equipamiento->getAlarma())
            {
                unset($equipamientos[$key]);
            }
        }
        if ($equipamientos==[])
        {
            $this->addFlash('success',sprintf('No hay equipamientos pendientes de realizar mantenimiento'));
            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'Equipamiento'
            ));
        }
        $elemento = array();
        $lista = array();       
        $elemento = [
            ['label' => 'Descripción', 'type' => 'string'],
            ['label' => 'Estado', 'type' => 'string'],
            ['label' => 'Fecha de adquisición', 'type' => 'string'],
            ['label' => 'Último mantenimiento', 'type' => 'string'],
            ['label' => 'Periodicidad', 'type' => 'string']
        ];
        array_push($lista, $elemento);

        foreach ($equipamientos as $equipamiento)
        {
            $elemento = array();
            array_push($elemento, $equipamiento->getDescripcion());
            array_push($elemento, $equipamiento->getEstado());
            array_push($elemento, (string)$equipamiento->getFechaAdquisicion()->format('Y/m/d'));
            array_push($elemento, (string)$equipamiento->getUltimoMantenimiento()->format('Y/m/d'));
            array_push($elemento, 'Cada '.$equipamiento->getMantenimientoDias().' días');
            array_push($lista, $elemento);
        }
       
        $table = new TableChart();
        $table->getData()->setArrayToDataTable($lista);    
        $now =  new \DateTime();

        return $this->render('/informes/informes.html.twig',
        array('chart' => $table,
        'titulo' => 'Informe de equipamientos que necesitan mantenimiento',
        'fechaimpresion' => ((string)$now->format('Y/m/d H:i:s'))
    ));
    }
}