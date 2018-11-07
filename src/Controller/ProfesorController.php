<?php

namespace App\Controller;

use App\Entity\Profesor;
use App\Entity\Clase;
use App\Entity\Inscripcion;
use App\Entity\Combo;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProfesorController extends AdminController
{
/*
SELECT clase.id as 'CLASE',COUNT(alumno.id) AS 'NumeroDeAlumnos'
FROM
profesor
INNER JOIN clase ON profesor.id=clase.profesor_id
INNER JOIN inscripcion ON clase.id=inscripcion.clase_id
INNER JOIN alumno ON alumno.id=inscripcion.alumno_id
WHERE inscripcion.fecha_inscripcion BETWEEN '2010-09-29 10:15:55' AND '2018-11-6 14:15:55'
GROUP BY clase.id
*/


    public function informarAction()
    {
        $id = $this->request->query->get('id');
        $em = $this->getDoctrine()->getEntityManager();
        $p = $em->getRepository(Profesor::Class)->find($id);

        $qb = $em->createQueryBuilder();
        $resultados = $qb
        ->addSelect('COUNT(a.id) as count')
        ->addSelect('c.id')
        ->from('App\Entity\Profesor','p')
        ->innerjoin('App\Entity\Clase','c','WITH','c.Profesor = p.id')
        ->innerjoin('App\Entity\Inscripcion','i','WITH','c.id = i.Clase')
        ->innerjoin('App\Entity\Alumno','a','WITH','a.id = i.Alumno')
        ->groupBy('c.id')
        ->where('p.id = :id')
        ->setParameter('id',$id)
        ->getQuery()
        ->getResult();
        //dump($resultados[0]);exit;
        if ($resultados)
        {
            $labels = '';
            $valores = '';
            foreach ($resultados as &$coso)
            {
                $labels = $labels.(string)$coso['id'];//.',';
                //$labels = substr_replace($labels ,"", -1);
                $valores = $valores.(string)$coso['count'];//.'|';
                //$valores = substr_replace($labels ,"", -1);
            }
        }
        $url = 'https://chart.googleapis.com/chart?cht=bvg&chs=300x300&';
        $url = $url.'chd=t:'.$valores.'&';
        $url = $url.'chl='.$labels;
        //dump($url);exit;





        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Write(11,utf8_decode($url));
        $pdf->Ln(10);
        $pdf->Image($url,60,30,90,0,'PNG');
        return new Response($pdf->Output(), 200, array(
            'Content-Type' => 'application/pdf'));    
    }
}