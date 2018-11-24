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

        $formModifier = function ($form, Clase $clase = null) {

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
    /**
     * The method that is executed when the user performs a 'new' action on an entity.
     *
     * @return Response|RedirectResponse
     */
    protected function newAction()
    {
        $this->dispatch(EasyAdminEvents::PRE_NEW);

        $entity = $this->executeDynamicMethod('createNew<EntityName>Entity');

        $easyadmin = $this->request->attributes->get('easyadmin');
        $easyadmin['item'] = $entity;
        $this->request->attributes->set('easyadmin', $easyadmin);

        $fields = $this->entity['new']['fields'];

        $newForm = $this->executeDynamicMethod('create<EntityName>NewForm', array($entity, $fields));

        $newForm->handleRequest($this->request);
        if ($newForm->isSubmitted() && $newForm->isValid()) {
            $this->dispatch(EasyAdminEvents::PRE_PERSIST, array('entity' => $entity));

            $this->executeDynamicMethod('prePersist<EntityName>Entity', array($entity, true));
            $this->executeDynamicMethod('persist<EntityName>Entity', array($entity));

            $this->dispatch(EasyAdminEvents::POST_PERSIST, array('entity' => $entity));

            return $this->redirectToRoute('easyadmin', array(
                'action' => 'list',
                'entity' => 'PagoCuota'
            ));
        }

        $this->dispatch(EasyAdminEvents::POST_NEW, array(
            'entity_fields' => $fields,
            'form' => $newForm,
            'entity' => $entity,
        ));

        $parameters = array(
            'form' => $newForm->createView(),
            'entity_fields' => $fields,
            'entity' => $entity,
        );
        return $this->executeDynamicMethod('render<EntityName>Template', array('new', $this->entity['templates']['new'], $parameters));

        
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