<?php
require_once "connection.php";
if (isset($_POST['submit_coment'])) {
    $comentary = $_POST['comentary'];
    $user      = $_POST['user'];
    $project   = $_POST['project'];
    $sql       = mysqli_query($conexion, "INSERT INTO commentary VAlUES (null,'$user','$project','$comentary')");
    if ($sql > 0) {
        echo "save";
    } else {
        printf("Error: %s\n", mysqli_error($conexion));
    }
} else {
    echo 'no';

}