<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use App\Entity\Movimiento;
use App\Entity\Caja;
use App\Entity\PagoCuota;
use App\Entity\Alumno;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AdminController
{
    public function persistEntity($entity)
    {
        parent::persistEntity($entity);
        UserPasswordEncoderInterface::$passwordEncoder;
        // 3) Encode the password (you could also do this via Doctrine listener)
        $password = $passwordEncoder->encodePassword($entity, $entity->getPlainPassword());
        $entity->setPassword($password);

        // 4) save the User!
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        $entityManager->flush();

        
    }

    
}
?>