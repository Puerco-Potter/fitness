<?php
namespace App\Controller;

use App\Form\AsistenciaType;
use App\Entity\AsistenciaAlumno;
use App\Entity\Alumno;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AsistenciaController extends AdminController
{   
    /**
     * @Route("/asistencia", name="asistencia")
     */
    public function asistencia(Request $request)
    {
        // 1) build the form
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('dni', NumberType::class)
        ->add('save', SubmitType::class, array('label' => 'Confirmar'))
            ->getForm();
    
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // 4) save the User!
            $data = $form->getData();
            
            if( 
                $alumno = $this->getDoctrine()
                    ->getRepository(Alumno::class)
                    ->findOneBy([
                        'dni' => $data["dni"]
                    ])
            ){
                $id= $alumno -> getId();
    
            return $this->redirectToRoute('asistencia2',array('id' => $id));
            }

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
        }

        return $this->render(
            'Asistencia/asistencia.html.twig',
            array('form' => $form->createView())
        );
    }
    /**
     * @Route("/asistencia2/{id}", name="asistencia2")
     */
    public function asistencia2(Request $request, $id)
    {
        // 1) build the form
        $asistencia = new AsistenciaAlumno();
        $form = $this->createForm(AsistenciaType::class, $asistencia, array(
            'id' => $id,
        ));

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($asistencia);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
        }

        return $this->render(
            'Asistencia/asistencia.html.twig',
            array('form' => $form->createView())
        );
    }
}