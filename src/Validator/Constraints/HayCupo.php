<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class HayCupo extends Constraint
{
    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }
    public $message = 'No hay más cupo en esta clase';
}