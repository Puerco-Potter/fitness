<?php
namespace App\Form;

use App\Entity\LineaPlan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class LineaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('musculo')
            ->add('ejercicio')
            ->add('observacion')
            ->add('f1')
            ->add('s1')
            ->add('r1')
            ->add('c1')
            ->add('f2')
            ->add('s2')
            ->add('r2')
            ->add('c2')
            ->add('f3')
            ->add('s3')
            ->add('r3')
            ->add('c3')
            ->add('f4')
            ->add('s4')
            ->add('r4')
            ->add('c4')
            ->add('f5')
            ->add('s5')
            ->add('r5')
            ->add('c5')
            ->add('f6')
            ->add('s6')
            ->add('r6')
            ->add('c6')
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LineaPlan::class,
        ]);
    }
}