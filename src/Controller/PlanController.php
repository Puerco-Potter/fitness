<?php

namespace App\Controller;

use App\Entity\LineaPlan;
use App\Entity\Actividad;
use App\Entity\Clase;
use App\Entity\Inscripcion;
use App\Entity\AsistenciaAlumno;
use App\Entity\PlanEntrenamiento;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\LineaType;

class PlanController extends AbstractController
{
    /**
     * @Route("/nuevoplan", name="nuevoPlan")
     */
    public function nuevoPlan(Request $request)
    {
        // creates a task and gives it some dummy data for this example
        $plan = new PlanEntrenamiento();

        $linea = new LineaPlan();
        //$linea ->setPlanEntrenamiento($plan);
        $plan->getLineas()->add($linea);

        $form = $this->createFormBuilder($plan)
            ->add('descripcion')
            ->add('Alumno')
            ->add('Profesor')
            ->add('dias1')
            ->add('dias2')
            ->add('dias3')
            ->add('dias4')
            ->add('dias5')
            ->add('dias6')
            ->add('lineas', CollectionType::class, array(
                'entry_type' => LineaType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
            ))
            ->add('save', SubmitType::class, array('label' => 'Crear Plan'))
            ->getForm();

        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $plan = $form->getData();
            
            foreach ($plan->getLineas() as $linea) {
                $linea ->setPlanEntrenamiento($plan);
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $plan = $form->getData();
    
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($plan);
             $entityManager->flush();
    
            return $this->redirectToRoute('planes');
        }

        //que mal la validacion no anda, prometo arreglarlo algun dia
        if ($form->isSubmitted() && !($form->isValid()) ) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $plan = $form->getData();
    
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($plan);
             $entityManager->flush();
    
            return $this->redirectToRoute('planes');
        }

        //Be aware that the createView() method should be called after handleRequest() is called.
         //Otherwise, changes done in the *_SUBMIT events aren't applied to the view (like validation errors).

        return $this->render('PlanEntrenamiento/nuevoplan.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/editarplan/{id}", name="editarPlan")
     */
    public function editarPlan(Request $request, $id)
    {
        // creates a task and gives it some dummy data for this example
        $plan = $this->getDoctrine()
                     ->getRepository(PlanEntrenamiento::class)
                     ->find($id);

        //$linea ->setPlanEntrenamiento($plan);

        $form = $this->createFormBuilder($plan)
            ->add('descripcion')
            ->add('Alumno')
            ->add('Profesor')
            ->add('dias1')
            ->add('dias2')
            ->add('dias3')
            ->add('dias4')
            ->add('dias5')
            ->add('dias6')
            ->add('lineas', CollectionType::class, array(
                'entry_type' => LineaType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
            ))
            ->add('save', SubmitType::class, array('label' => 'Guardar Cambios'))
            ->getForm();

        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $plan = $form->getData();
            
            foreach ($plan->getLineas() as $linea) {
                $linea ->setPlanEntrenamiento($plan);
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $plan = $form->getData();
    
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($plan);
             $entityManager->flush();
    
            return $this->redirectToRoute('planes');
        }

        //que mal la validacion no anda, prometo arreglarlo algun dia
        if ($form->isSubmitted() && !($form->isValid()) ) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $plan = $form->getData();
    
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($plan);
             $entityManager->flush();
    
            return $this->redirectToRoute('planes');
        }

        //Be aware that the createView() method should be called after handleRequest() is called.
         //Otherwise, changes done in the *_SUBMIT events aren't applied to the view (like validation errors).

        return $this->render('PlanEntrenamiento/nuevoplan.html.twig', array(
            'form' => $form->createView(),
        ));
    }

     /**
     * @Route("/planes", name="planes")
     */
    public function planes()
    {
        $planes = $this->getDoctrine()
                     ->getRepository(PlanEntrenamiento::class)
                     ->findAll();

        return $this->render('PlanEntrenamiento/planes.html.twig', array(
            'planes' => $planes,
        ));
    }

     /**
     * @Route("/plan/{id}", name="plan")
     */
    public function plan($id)
    {
        $plan = $this->getDoctrine()
                     ->getRepository(PlanEntrenamiento::class)
                     ->find($id);

        return $this->render('PlanEntrenamiento/plan.html.twig', array(
            'plan' => $plan,
        ));
    }

     /**
     * @Route("/plan_planilla/{id}", name="plan_planilla")
     */
    public function plan_planilla($id)
    {
        $plan = $this->getDoctrine()
                     ->getRepository(PlanEntrenamiento::class)
                     ->find($id);

        return $this->render('PlanEntrenamiento/plan_planilla.html.twig', array(
            'plan' => $plan,
        ));
    }

     /**
     * @Route("/panel", name="panel")
     */
    public function panel()
    {
        $user = $this->getUser();
        return $this->render('PlanEntrenamiento/panel.html.twig', array(
            "user" => $user
        ));
    }

     /**
     * @Route("/asistenciapanel", name="asistenciapanel")
     */
    public function asistencia()
    {
        $clases = $this->getDoctrine()
                     ->getRepository(Clase::class)
                     ->findAll();

        return $this->render('PlanEntrenamiento/asistencia.html.twig', [
            'clases' => $clases,
        ]
        );
    }

     /**
     * @Route("/asistenciaClase/{id}", name="asistenciaClase")
     */
    public function asistenciaClase($id)
    {
        $clase = $this->getDoctrine()
                     ->getRepository(Clase::class)
                     ->find($id);
        $inscripciones = $this->getDoctrine()
                     ->getRepository(Inscripcion::class)
                     ->findBy(['Clase' => $id]);

        foreach ($inscripciones as $key => $inscripcion)
        {
            if ($inscripcion->getFechaFin()<=(new \DateTime()))
            {
                unset($inscripciones[$key]);
            }
        }

        $asistencias = $this->getDoctrine()
                     ->getRepository(AsistenciaAlumno::class)
                     ->findByFecha(new \DateTime("now"));

        $hoy = date("d/m/Y");

        return $this->render('PlanEntrenamiento/asistenciaClase.html.twig', [
            'clase' => $clase,
            'hoy' => $hoy,
            'inscripciones' => $inscripciones,
            'asistencias' => $asistencias
        ]
        );
    }
    
}