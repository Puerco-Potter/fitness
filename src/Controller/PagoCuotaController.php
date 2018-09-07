<?php

namespace App\Controller;

use App\Entity\PagoCuota;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PagoCuotaController extends AdminController
{
    public function __construct()
    {
        //parent::__construct();
        //print '_PagoCuotaController se creó_';
    }

    public function redirigir()
    {
        return $this->redirectToRoute('login');
    }
}
?>