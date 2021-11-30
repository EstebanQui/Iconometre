<?php
require_once 'connection.php';
$question    = 3;
$description = 'Respuesta 5';
$sql         = mysqli_query($conexion, "INSERT INTO answers_questions values(null,'$question','$description')");
if ($sql > 0) {
    echo 'guardado';
} else {
    echo 'no guardado';
}
