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
            
            $pdf = new \FPDF();

            $pdf->AddPage();
            $pdf->SetFont('Arial','B',16);
            $pdf->Cell(40,10,'Hello World!');

            return new Response($pdf->Output(), 200, array(
                'Content-Type' => 'application/pdf'));            
            //$pdf = $this->container->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            /*
            $pdf = $this->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetAuthor('Our Code World');
            $pdf->SetTitle(('Our Code World Title'));
            $pdf->SetSubject('Our Code World Subject');
            $pdf->setFontSubsetting(true);
            $pdf->SetFont('helvetica', '', 11, '', true);
            //$pdf->SetMargins(20,20,40, true);
            $pdf->AddPage();
            
            $filename = 'ourcodeworld_pdf_demo';
            
            $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
            $pdf->Output($filename.".pdf",'I'); // This will output the PDF as a response directly
            */
            /*        
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
            $this->get('knp_snappy.pdf')->setBinary("\"C:\\wamp64\\www\\fitness\\vendor\\h4cc\\wkhtmltopdf\\bin\\");
            //dump($this->get('knp_snappy.pdf'));exit;//->getOptions());exit;;
            //dump($this->get('knp_snappy.pdf')->getOptions());exit;;
            //$this->get('knp_snappy.pdf')->setOption('route', '/');
            $this->get('knp_snappy.pdf')->generate('http://www.google.fr', 'coso.pdf');
            */
            // Message + redirection
            $this->addFlash('success', 'Yey');

        return $this->redirectToRoute('easyadmin', array(
            'action' => 'list',
            'entity' => 'FichaMedica'
        ));
    }
}