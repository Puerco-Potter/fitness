<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\Entity\AlumnoInactivo;
use App\Entity\FichaMedica;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as coso;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FichaMedicaController extends AdminController
{

    public function imprimirAction()
    {
            // get contract from database
            $id = $this->request->query->get('id');
            $em = $this->getDoctrine()->getEntityManager();
            $fc = $em->getRepository(FichaMedica::Class)->find($id);
        
            $path = $this->request->server->get('DOCUMENT_ROOT');    // C:/wamp64/www/
            $path = rtrim($path, "/");                         // C:/wamp64/www
        
            $html = $this->renderView('pdf/content.html.twig', array('c' => $fc));
        
            $header = $this->renderView('pdf/header.html.twig', array(
                'path' => $path
            ));
            $footer = $this->renderView('pdf/footer.html.twig', array(
                'customer' => $fc->getAlumno()
            ));
        
            $output = $path . $this->request->server->get('BASE');        // C:/wamp64/www/project/web
            $output .= '/pdf/'.(string) $fc->getAlumno() .'.pdf';
            #dump($html);exit;
            // Generate PDF file
            $this->get('knp_snappy.pdf')->generate('http://www.google.fr', '/path/to/the/image.jpg');
        
            // Message + redirection
            $this->addFlash('success', 'Yey');

        return $this->redirectToRoute('easyadmin', array(
            'action' => 'list',
            'entity' => 'FichaMedica'
        ));
    }
}