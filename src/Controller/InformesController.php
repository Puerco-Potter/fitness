<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InformesController extends AbstractController
{
    /**
     * @Route("/informes", name="informes")
     */
    public function index()
    {
        return $this->render('informes/informes.html.twig', [
            'controller_name' => 'InformesController',
        ]);
    }
}
