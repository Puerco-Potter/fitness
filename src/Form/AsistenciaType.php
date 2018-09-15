<?php
namespace App\Form;

use App\Entity\AsistenciaAlumno;
use App\Entity\Inscripcion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\InscripcionRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AsistenciaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $id = $options["id"];
        $builder
            ->add('fecha', DateType::class, array(
                'widget' => 'single_text',
                'label' => false,
                // prevents rendering it as type="date", to avoid HTML5 date pickers
            ))
            ->add('hora', TimeType::class, array(
                'widget' => 'single_text',
                'label' => false,
                // prevents rendering it as type="date", to avoid HTML5 date pickers
            ))
            ->add('inscripcion',EntityType::class, array(
            // looks for choices from this entity
            'class' => Inscripcion::class,
            'label' => false,
            // filtra la entidad
            'query_builder' => function (InscripcionRepository $er)  use($id) {
                return $er->createQueryBuilder('u')
                        ->where('u.Alumno = '. $id);
            },
            'choice_label' => function (Inscripcion $inscripcion = null) {
                return null === $inscripcion ? '': $inscripcion->conseguir_asistencia();
            },
            ))
            ->add('save', SubmitType::class, array('label' => 'Confirmar'))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('id');
        $resolver->setDefaults(array(
            'data_class' => AsistenciaAlumno::class,
        ));
    }
}