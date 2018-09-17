<?php
namespace App\Controller;

use App\Form\AsistenciaType;
use App\Entity\AsistenciaAlumno;
use App\Entity\Inscripcion;
use App\Entity\Alumno;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AsistenciaController extends AdminController
{   
    public function persistEntity($entity)
    {
        parent::persistEntity($entity);
        $id = $entity->getInscripcion()->getId();

        $em = $this->getDoctrine()->getEntityManager();

        $qb = $this->em->createQueryBuilder();
        $qb->update('App\Entity\Inscripcion','i')
            ->set('i.clasesRestantes','i.clasesRestantes - 1')
            ->where('i.id = '.(string)$id);
        return $qb->getQuery()->getResult();
    }

    /**
     * @Route("/asistencia", name="asistencia")
     */
    public function asistencia(Request $request)
    {
        // 1) build the form
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
        ->add('dni', NumberType::class, array('label' => false))
        ->add('save', SubmitType::class, array('label' => 'Confirmar'))
            ->getForm();
        
        $aviso = "";
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
            $aviso = "El documento no se encuentra registrado";
            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
        }

        return $this->render(
            'Asistencia/asistencia.html.twig',
            array('form' => $form->createView(), "aviso" => $aviso)
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
            

            $id = $asistencia->getInscripcion()->getId();
            
            $inscripcion = $this->getDoctrine()
                     ->getRepository(Inscripcion::class)
                     ->findOneBy(array('id' => $id));
            $inscripcion ->setClasesRestantes($inscripcion ->getClasesRestantes() - 1);
            $entityManager->persist($inscripcion);
            $entityManager->flush();
            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            return $this->redirectToRoute('asistencia3');
        }

        return $this->render(
            'Asistencia/asistencia2.html.twig',
            array('form' => $form->createView())
        );
    }
    /**
     * @Route("/asistencia3", name="asistencia3")
     */
    public function asistencia3()
    {
        return $this->render(
            'Asistencia/asistencia3.html.twig'
        );
    }
}