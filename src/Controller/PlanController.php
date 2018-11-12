<?php

namespace App\Controller;

use App\Entity\LineaPlan;
use App\Entity\PlanEntrenamiento;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\Lineatype;

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
}