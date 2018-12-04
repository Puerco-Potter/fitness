<?php

namespace App\Controller;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
    
    protected function removeEntity($entity)
    {
        parent::removeEntity($entity);
        $this->addFlash('warning',sprintf('Se ha eliminado correctamente'));
    }

    protected function updateEntity($entity)
    {
        parent::updateEntity($entity);
        $clUpdt = get_class($entity);
            if (strpos($clUpdt, 'Actividad') == true)  { $clUpdt = 'Actividad - ';}
            if (strpos($clUpdt, 'Alumno') == true)  { $clUpdt = 'Alumno - ';}
            if (strpos($clUpdt, 'AsistenciaAlumno') == true)  { $clUpdt = 'Asistencia - ';}
            if (strpos($clUpdt, 'Actividad') == true)  { $clUpdt = 'Actividad - ';}
            if (strpos($clUpdt, 'Caja') == true)  { $clUpdt = '';}
            if (strpos($clUpdt, 'Clase') == true)  { $clUpdt = 'Clase - ';}
            if (strpos($clUpdt, 'Combo') == true)  { $clUpdt = 'Combo - ';}
            if (strpos($clUpdt, 'Ejercicio') == true)  { $clUpdt = 'Ejercicio - ';}
            if (strpos($clUpdt, 'Elemento') == true)  { $clUpdt = 'Elemento - ';}
            if (strpos($clUpdt, 'Empleado') == true)  { $clUpdt = 'Empleado - ';}
            if (strpos($clUpdt, 'Clase') == true)  { $clUpdt = 'Clase - ';}
            if (strpos($clUpdt, 'y\Entrenamiento') == true)  { $clUpdt = 'Entrenamiento - ';}
            if (strpos($clUpdt, 'Equipamiento') == true)  { $clUpdt = 'Equipamiento - ';}
            if (strpos($clUpdt, 'ESEmpleado') == true)  { $clUpdt = '';}
            if (strpos($clUpdt, 'FichaMedica') == true)  { $clUpdt = 'Ficha Médica - ';}
            if (strpos($clUpdt, 'Inscripcion') == true)  { $clUpdt = 'Inscripción - ';}
            if (strpos($clUpdt, 'Movimiento') == true)  { $clUpdt = '';}
            if (strpos($clUpdt, 'Musculo') == true)  { $clUpdt = 'Músculo - ';}
            if (strpos($clUpdt, 'PagoCuota') == true)  { $clUpdt = '';}
            if (strpos($clUpdt, 'PlanEntrenamiento') == true)  { $clUpdt = 'Plan - ';}
            if (strpos($clUpdt, 'Profesor') == true)  { $clUpdt = 'Profesor - ';}
            if (strpos($clUpdt, 'RegistroMantenimiento') == true)  { $clUpdt = 'Mantenimiento - ';}
            if (strpos($clUpdt, 'RegistroSuplencia') == true)  { $clUpdt = '';}
            if (strpos($clUpdt, 'Sala') == true)  { $clUpdt = 'Salón - ';}
            if (strpos($clUpdt, 'RegistroMantenimiento') == true)  { $clUpdt = 'Mantenimiento - ';}
            if (strpos($clUpdt, 'Telefono') == true)  { $clUpdt = 'Teléfono - ';}
            if (strpos($clUpdt, 'User') == true)  { $clUpdt = 'Usuario - ';}       
        $this->addFlash('success',sprintf('Se ha actualizado: '.(string)$clUpdt.$entity->__toString()));
    }

    protected function persistEntity($entity)
    {
        parent::persistEntity($entity);
        
        #$id = $this->request->query->get('id');
        #$entity = $this->em->getRepository('App:Alumno')->find($id);
		$usr = $this->get('security.token_storage')->getToken()->getUser();
		$usr->getUsername();
        $clReg = get_class($entity);
            if (strpos($clReg, 'Actividad') == true)  { $clReg = 'Actividad - ';}
            if (strpos($clReg, 'Alumno') == true)  { $clReg = 'Alumno - ';}
            if (strpos($clReg, 'AsistenciaAlumno') == true)  { $clReg = 'Asistencia - ';}
            if (strpos($clReg, 'Actividad') == true)  { $clReg = 'Actividad - ';}
            if (strpos($clReg, 'Caja') == true)  { $clReg = '';}
            if (strpos($clReg, 'Clase') == true)  { $clReg = 'Clase - ';}
            if (strpos($clReg, 'Combo') == true)  { $clReg = 'Combo - ';}
            if (strpos($clReg, 'Ejercicio') == true)  { $clReg = 'Ejercicio - ';}
            if (strpos($clReg, 'Elemento') == true)  { $clReg = 'Elemento - ';}
            if (strpos($clReg, 'Empleado') == true)  { $clReg = 'Empleado - ';}
            if (strpos($clReg, 'Clase') == true)  { $clReg = 'Clase - ';}
            if (strpos($clReg, 'y\Entrenamiento') == true)  { $clReg = 'Entrenamiento - ';}
            if (strpos($clReg, 'Equipamiento') == true)  { $clReg = 'Equipamiento - ';}
            if (strpos($clReg, 'ESEmpleado') == true)  { $clReg = '';}
            if (strpos($clReg, 'FichaMedica') == true)  { $clReg = 'Ficha Médica - ';}
            if (strpos($clReg, 'Inscripcion') == true)  { $clReg = 'Inscripción - ';}
            if (strpos($clReg, 'Movimiento') == true)  { $clReg = '';}
            if (strpos($clReg, 'Musculo') == true)  { $clReg = 'Músculo - ';}
            if (strpos($clReg, 'PagoCuota') == true)  { $clReg = '';}
            if (strpos($clReg, 'PlanEntrenamiento') == true)  { $clReg = 'Plan - ';}
            if (strpos($clReg, 'Profesor') == true)  { $clReg = 'Profesor - ';}
            if (strpos($clReg, 'RegistroMantenimiento') == true)  { $clReg = 'Mantenimiento - ';}
            if (strpos($clReg, 'RegistroSuplencia') == true)  { $clReg = '';}
            if (strpos($clReg, 'Sala') == true)  { $clReg = 'Salón - ';}
            if (strpos($clReg, 'RegistroMantenimiento') == true)  { $clReg = 'Mantenimiento - ';}
            if (strpos($clReg, 'Telefono') == true)  { $clReg = 'Teléfono - ';}
            if (strpos($clReg, 'User') == true)  { $clReg = 'Usuario - ';}
        $this->addFlash('success',sprintf('Se ha registrado en el sistema: '.(string)$clReg.$entity->__toString()));
        /*
        return $this->redirectToRoute('easyadmin', [
            'action' => 'show',
            'entity' => $this->request->query->get('entity'),
            'id' => $id,
        ]);
        */
    }
	

}