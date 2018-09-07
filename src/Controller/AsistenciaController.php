<?php
namespace App\Controller;

use App\Form\AsistenciaType;
use App\Entity\AsistenciaAlumno;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AsistenciaController extends AdminController
{
    /**
     * @Route("/asistencia", name="asistencia")
     */
    public function asistencia(Request $request)
    {
        // 1) build the form
        $asistencia = new AsistenciaAlumno();
        $form = $this->createForm(AsistenciaType::class, $asistencia);

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