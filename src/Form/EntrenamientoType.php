<?php
namespace App\Form;

use App\Entity\Entrenamiento;
use App\Entity\Ejercicio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class EntrenamientoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Ejercicio', EntityType::class, [
                    'class' => Ejercicio::class,
                    'choice_label' => 'descripcion',
                ])
            ->add('Series', NumberType::class, [
                'label' => 'Series',
            ])
            ->add('Peso', NumberType::class, [
                'label' => 'Peso (kg)',
            ])
            ->add('Descansos', NumberType::class, [
                'label' => 'Descansos (segundos)',
            ])
            ->add('Observaciones', TextType::class, [
                'label' => 'Observaciones',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entrenamiento::class,
        ]);
    }
}
