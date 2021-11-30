<?php
require_once 'connection.php';
$question = 'pregunta 5';
$stat     = 1;
$project  = 1;
$sql      = mysqli_query($conexion, "INSERT INTO questions values(null,'$question','$stat','$project')");
if ($sql > 0) {
    echo 'save';
} else {
    echo 'not save';
}
