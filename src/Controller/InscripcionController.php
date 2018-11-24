<?php

namespace App\Controller;

use App\Entity\Inscripcion;
use App\Entity\Alumno;
use App\Entity\PagoCuota;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormEvents;

class InscripcionController extends AdminController
{
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
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            
            $product = $event->getData();
            $form = $event->getForm();
        });
        dump($event);exit;
        if ($entity->getClase())
        {
            $clase = $entity->getClase();
            $precio = $clase->getCuotaBase();
            $builder->add
            ('cuota', NumberType::class,
                [
                    'data' => 100
                ]
            );
        }
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