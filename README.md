"# fitness" 
</br>
php bin/console make:entity
</br>
php bin/console doctrine:schema:update --force
</br>
php bin/console cache:clear --env=dev
</br>

public function createEntityFormBuilder($entity, $view)
{
//consigo las tematicas de ese usuario
if (false === $this->isGranted('ROLE_SUPER_ADMIN')) {
$user = $this->getUser();
$ong = $user->getOng();
if ($ong) {
$tematicas = $ong->getTematicas();
} else {
$ongColaborator = $user->getOngColaborator();
$tematicas = $ongColaborator->getTematicas();
}
} else {
//o todas las tematicas
$tematicas = $this->getDoctrine()->getRepository(Tematica::Class)->findAll();
}
//armo el string para el WHERE IN
$tematicasIN = "( ";
foreach ($tematicas as $tematica) {
$tematicasIN = $tematicasIN . $tematica->getId() . ", ";
}
//quito la ultima coma
if (count($tematicas) != 0) {
$tematicasIN = substr($tematicasIN, 0, -2);
} else {
$tematicasIN = $tematicasIN . "0 ";
}
$tematicasIN = $tematicasIN . ")";

$formBuilder = parent::createEntityFormBuilder($entity, $view);

$formBuilder->add('tematicas', EntityType::class, array(
'class' => Tematica::class,
'multiple' => true,
'expanded' => true,
'query_builder' => function (EntityRepository $er) use ($tematicasIN) {
return $er->createQueryBuilder('t')
->where('t.id IN ' . $tematicasIN)
->orderBy('t.nombre', 'ASC');
},
));

return $formBuilder;
}



<b>Tareas e historias de usuario</b></br>
<b>Primer release</b></br>
<b>Alumnos</b></br>
Registro de datos personales</br>
Modificación de datos personales</br>
Registro de ficha médica</br>
Consulta de datos personales</br>
Baja de alumno</br>

<b>Profesores</b></br>
Registro de datos personales</br>
Modificación de datos</br>
Consulta de datos</br>
Baja de profesor</br>

<b>Inventario</b></br>
Alta de equipamiento/elemento</br>
Baja de equipamiento/elemento</br>
Modificación de equipamiento/elemento</br>

<b>Actividades</b></br>
Registrar actividad</br>
Eliminar actividad</br>
Modificar actividad</br>

<b>Segundo Release</b></br>
</br>
<b>Gestión de planes de entrenamiento</b></br>
Registrar plantillas de planes de entrenamiento</br>
Registrar plan de entrenamiento de Alumno</br>
<b>Gestión de Clases</b></br>
Registro de clases</br>
Modificar clases</br>
Inscripción a clases</br>
Asignación de profesores</br>
<b>Gestión de salas</b></br>

<b>Tercer Release</b></br>
</br>
<b>Control de Asistencias</b></br>
Registro de asistencias de alumnos</br>
Registro de entrada de profesores</br>
Registro de salida de profesores</br>
Consulta de asistencias de alumnos</br>
Consulta de asistencias de profesores</br>
<b>Registro de pagos</b></br>
Registro de pago de cuotas</br>
Registro de pago de servicios</br>
<b>Manejo de cuotas de Alumnos</b></br>
Consultas estados de alumnos</br>
Establecimiento de periodicidades de pagos</br>
Establecimiento prórrogas de pago</br>
Registro aviso de faltas futuras</br>
<b>Gestión de suplencias de profesores</b></br>
Asentamiento de licencia de profesores</br>
Asignación de suplentes</br>

<b>Cuarto Release</b></br>
</br>
<b>Gestión de caja</b></br>
Gestión de Ingresos de Caja</br>
Gestión de Egresos de Caja</br>
Apertura y cierre de Caja</br>
<b>Emitir Informes de Caja</b></br>
Movimientos de Caja</br>
Informe de liquidación </br>
Emitir Informe de alumnos morosos</br>
<b>Emisión informes del profesor</b></br>
Informe de alumnos</br>
Alumnos por profesor</br>
Alumnos propios</br>
Informe de ingresos por profesor</br>
<b>Emitir informe de Actividad</b>
<b>Gestión de combos</b></br>
Creación y modificación de combos</br>
Aplicación de combos</br>

Informes