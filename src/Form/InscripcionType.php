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
                ])
            ->add('clasesRestantes', NumberType::class, [
                'label' => 'Clases Restantes',
            ])
            ->add('clasesTotales', NumberType::class, [
                'label' => 'Clases Totales',
            ])
            ->add('lunes', CheckboxType::class, [
                'label' => 'Lunes',
            ])
            ->add('martes', CheckboxType::class, [
                'label' => 'Martes',
            ])
            ->add('miercoles', CheckboxType::class, [
                'label' => 'Miercoles',
            ])
            ->add('jueves', CheckboxType::class, [
                'label' => 'Jueves',
            ])
            ->add('viernes', CheckboxType::class, [
                'label' => 'Viernes',
            ])
            ->add('sabado', CheckboxType::class, [
                'label' => 'Sabado',
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