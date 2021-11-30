<?php
require_once 'connection.php';
$name = 'Administrator';
$stat = 1;

$sql = mysqli_query($conexion, "INSERT INTO roles values(null,'$name','$stat')");
if ($sql > 0) {
    echo 'Save';
} else {
    echo 'Not Save';
}