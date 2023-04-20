<?php
// Conexión a la base de datos PostgreSQL
$dbconn = pg_connect("host=localhost dbname=exams user=postgres password=1234");

// Verificar si la conexión fue exitosa
if(!$dbconn){
    echo "Error: No se pudo conectar a la base de datos.";
    exit;
}

// Obtener el id y el estado de la historia
$id = $_POST['id'];
$estado = $_POST['estado'];

// Actualizar el estado de la historia en la tabla "historias"
$query = "UPDATE historias SET estado='$estado' WHERE id=$id";
$result = pg_query($dbconn, $query);

// Verificar si se realizó la actualización correctamente
if(!$result){
    echo "Error: No se pudo actualizar el estado de la historia.";
    exit;
}

// Cerrar la conexión a la base de datos
pg_close($dbconn);
?>
