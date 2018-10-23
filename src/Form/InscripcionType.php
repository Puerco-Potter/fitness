<?php
namespace App\Form;

use App\Entity\Inscripcion;
use App\Entity\Clase;
use App\Entity\Alumno;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class InscripcionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Clase', EntityType::class, [
                    'class' => Clase::class,
                    'attr' => array('class' => 'col-lg-6')
                ])
            ->add('clasesRestantes', NumberType::class, [
                'label' => 'Clases Restantes',
                'attr' => array('class' => 'col-lg-6')
            ])
            ->add('clasesTotales', NumberType::class, [
                'label' => 'Clases Totales',
                'attr' => array('class' => 'col-lg-6')
            ])
            ->add('lunes', CheckboxType::class, [
                'label' => 'Lunes',
                'attr' => array('class' => 'col-lg-6')
            ])
            ->add('martes', CheckboxType::class, [
                'label' => 'Martes',
                'attr' => array('class' => 'col-lg-6')
            ])
            ->add('miercoles', CheckboxType::class, [
                'label' => 'Miercoles',
                'attr' => array('class' => 'col-lg-6')
            ])
            ->add('jueves', CheckboxType::class, [
                'label' => 'Jueves',
                'attr' => array('class' => 'col-lg-6')
            ])
            ->add('viernes', CheckboxType::class, [
                'label' => 'Viernes',
                'attr' => array('class' => 'col-lg-6')
            ])
            ->add('sabado', CheckboxType::class, [
                'label' => 'Sabado',
                'attr' => array('class' => 'col-lg-6')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inscripcion::class,
        ]);
    }
}