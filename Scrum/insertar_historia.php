<?php
// Conexión a la base de datos PostgreSQL
$dbconn = pg_connect("host=localhost dbname=exams user=postgres password=1234");

// Verificar si la conexión fue exitosa
if (!$dbconn) {
    echo "Error: No se pudo conectar a la base de datos.";
    exit;
}

// Obtener los datos del formulario
$titulo = isset($_POST['titulo']) ? $_POST['titulo'] : '';
$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
$prioridad = isset($_POST['prioridad']) ? (int) $_POST['prioridad'] : 1;
$estado = isset($_POST['estado']) ? $_POST['estado'] : '';
$fecha_limite = isset($_POST['fecha_limite']) ? $_POST['fecha_limite'] : '';

// Validar los datos del formulario
if (empty($titulo) || empty($descripcion) || !in_array($prioridad, array(1, 2, 3)) || empty($estado) || empty($fecha_limite)) {
    echo "Error: Los datos del formulario no son válidos.";
    exit;
}

// Obtener la fecha actual del sistema
$fecha_actual = date('Y-m-d');

// Insertar los datos en la tabla "historias"
$query = "INSERT INTO historias (titulo, descripcion, prioridad, estado, fecha_limite, fecha_creacion) VALUES ($1, $2, $3, $4, $5, $6)";
$result = pg_query_params($dbconn, $query, array($titulo, $descripcion, $prioridad, $estado, $fecha_limite, $fecha_actual));

// Verificar si la consulta fue exitosa
if (!$result) {
    echo "Error: No se pudo ejecutar la consulta.";
    exit;
}

// Cerrar la conexión a la base de datos
pg_close($dbconn);

// Crear una respuesta JSON con el resultado de la operación
$response = array(
    'success' => true,
    'message' => 'La historia se ha insertado correctamente.'
);

// Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
exit;
