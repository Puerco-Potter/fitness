<?php
namespace App\Form;

use App\Entity\Telefono;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
class TelefonoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Tipo', ChoiceType::class, [
                'label' => 'Tipo',
                'choices'  => array(
                    'Celular' => "Celular",
                    'Fijo' => "Fijo",
                ),
            ])
            ->add('Caracteristica', NumberType::class, [
                'label' => 'Caracteristica',
            ])
            ->add('Numero', NumberType::class, [
                'label' => 'Numero',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Telefono::class,
        ]);
    }
}
