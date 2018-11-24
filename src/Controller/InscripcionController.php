<?php

namespace App\Controller;

use App\Entity\Inscripcion;
use App\Entity\Alumno;
use App\Entity\PagoCuota;
use App\Entity\Clase;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\HttpFoundation\Request;

class InscripcionController extends AdminController
{
    
    public function create(Request $request)
    {
        $meetup = new Inscripcion();
        $form = $this->createForm(Inscripcion::class, $inscripcion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // ... save the meetup, redirect etc.
        }
        dump('AAAAAAAAAAAAAA');exit;

        return $this->render(
            'inscripcion/crear.html.twig',
            array('form' => $form->createView())
        );
    }
    /**
     * Creates the form builder of the form used to create or edit the given entity.
     *
     * @param object $entity
     * @param string $view   The name of the view where this form is used ('new' or 'edit')
     *
     * @return FormBuilder
     */
     public function createEntityFormBuilder($entity, $view)
    {
        $builder = parent::createEntityFormBuilder($entity, $view);
        
        $builder
            ->add('clase', EntityType::class, array(
                'class'       => 'App\Entity\Clase',
                'placeholder' => '',
            ));
        ;

        $formModifier = function ($form, Clase $clase = null)
        {
            $precio = null === $clase ? 0 : $clase->getCuotaBase();
            $form->add('cuota', NumberType::class, array(
                'data' => $precio
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function ($event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $ins = $event->getData();

                $formModifier($event->getForm(), $ins->getClase());
            }
        );

        $builder->get('clase')->addEventListener(
            FormEvents::POST_SUBMIT,
            function ($event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $clase = $event->getForm()->getData()->getClase();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $clase);
            }
        );
        return $builder;
    }
    public function persistEntity($entity)
    {
        parent::persistEntity($entity);
        $em = $this->getDoctrine()->getEntityManager();
        $id = $entity->getAlumno()->getId();
        $monto = $entity->getCuota();

        $entity->setSaldo(-$monto);
        $em->persist($entity);

        $a = ($em->getRepository(Alumno::class)->findBy(array('id' => $entity->getAlumno()->getId())))[0];
        $a->setBalance($a->getBalance()-$monto);
        $em->persist($a);
        $em->flush();
    }
}